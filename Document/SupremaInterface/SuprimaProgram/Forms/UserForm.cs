using BaseDAL.Base;
using BaseDAL.Model;
using Newtonsoft.Json;
using SuprimaProgram.Helper;
using SuprimaProgram.Helper.Enum;
using SuprimaProgram.Model;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;

using FP = FingerPrintController;

namespace SuprimaProgram.Forms
{
    public partial class UserForm : Form
    {

        #region Variable

        private TcpClient client = null;

        private PersonModel personResult = null;

        private ComboDataModel dataResult = null;
        private int finger_image_quality = 0;
        private int finger_user_id = 0;
        private int? user_id = 0;

        private ImageLoader imageLoader;

        private EnumReceiveMode receiveMode = EnumReceiveMode.TEXT;

        private Thread connectThread = null;

        //private uint userId
        //{
        //    get
        //    {
        //        return (uint)userIdUpDown.Value;
        //    }
        //}

        private byte subId = 0;

        private string tData = "";


        #endregion


        #region Methods


        public UserForm()
        {
            InitializeComponent();

            init();
        }

        /// <summary>
        /// Initilizer
        /// </summary>
        private void init()
        {
            updateUi();
            
            prepare();

            bindEvents();
        }

        /// <summary>
        /// Bind Events
        /// </summary>
        private void bindEvents()
        {
            enrollButton.Click                  += enrollButton_Click;

            nextButton.Click                    += nextButton_Click;

            previousButton.Click                += previousButton_Click;

            finishButton.Click                  += finishButton_Click;

            saveFingerprintButton.Click         += saveFingerprintButton_Click;

            mainTabControl.SelectedIndexChanged += MainTabControl_SelectedIndexChanged;

        }

      

        /// <summary>
        /// Prepare
        /// </summary>
        private void prepare()
        {
            reloadCombo();

            try
            {
                connectThread?.Abort();
              
            }
            finally
            {
                connectThread = null;
            }

            client = new TcpClient();
            client.Connect("127.0.0.1", 10000);

            

            connectThread = new Thread(() =>
            {
                while (client?.Connected == true)
                {
                    byte[] data = new byte[1024];

                    try
                    {
                        int len = client.GetStream()
                                        .Read(data,
                                               0,
                                               data.Length);

                        if (len == 0)
                        {
                            return;
                        }

                        byte[] pureData = new byte[len];


                        Array.Copy(data,
                                    pureData,
                                    len);

                        log(pureData);
                    }
                    catch (Exception ex)
                    {
                        log(ex.Message);
                    }
                }
            
            });

            connectThread.Start();

            write(client, FP.FingerPrintController.C_DEVICES_LIST);
        }


        /// <summary>
        /// Load Combo fingerprint device 
        /// </summary>
        /// <param name="msg"></param>
        private void log(byte[] data)
        {
            // Parse data
            string str = System.Text.Encoding.UTF8.GetString(data);


            if (str.StartsWith(FP.FingerPrintController.C_BEGIN_IMAGE))
            {
                receiveMode = EnumReceiveMode.IMAGE;

                string[] subData = str.Split('\t');

                int size = Convert.ToInt32(subData[1]);

                imageLoader = new ImageLoader(size);
            }
            else if (str.StartsWith(FP.FingerPrintController.C_END_IMAGE))
            {
                //enrollPictureBox.Image = null;
                enrollPictureBox.Image = imageLoader?.toBitmap();

                receiveMode = EnumReceiveMode.TEXT;
            }
            else
            {
                if (receiveMode == EnumReceiveMode.IMAGE)
                {
                    imageLoader?.addBytes(data);
                }
                else
                {
                    log(str);
                }
            }

        }

        /// <summary>
        /// Log Message
        /// </summary>
        /// <param name="msg"></param>
        private void log(string msg)
        {
            //this.Invoke(new Action(() =>
            //{
            //    //logListBox.Items.Insert(0,
                //                        msg);

                string[] data = msg.Split(FP.FingerPrintController.C_SEPARATOR);

                if (data[0] == FingerPrintController.FingerPrintController.C_DEVICES_LIST)
                {
                    devicesComboBox.Items.Clear();

                    devicesComboBox.Items.AddRange(data);

                    devicesComboBox.SelectedIndex = 1;
                }

                else if (data[0] == FingerPrintController.FingerPrintController.C_READ_TEMPLATE)
                {
                    tData = data[3];
                }

                else if (data[0] == FingerPrintController.FingerPrintController.C_IDENTIFY_TEMPLATE)
                {
                }

                else if (data[0] == FingerPrintController.FingerPrintController.C_READ_IMAGE)
                {
                    //picFinger.Image = Image.FromHbitmap(data[1]);
                }

                else if (data[0] == FingerPrintController.FingerPrintController.C_ENROLL)
                {
                    this.Invoke(new Action(() =>
                    {
                        finger_user_id = Convert.ToInt32(data[1]);
                        finger_image_quality = Convert.ToInt32(data[2]);
                        fingerprintUserIdTextBox.Text = data[1];
                        qualityTextBox.Text = data[2] + "%";

                        readTemplate();

                    }));
                }
        }


        private void MainTabControl_SelectedIndexChanged(object sender, EventArgs e)
        {
            updateUi();
        }


        /// <summary>
        /// Update UI
        /// </summary>
        private void updateUi()
        {
            int step = mainTabControl.SelectedIndex;
            int count = mainTabControl.TabPages.Count;
            //(step > count -1)
            previousButton.Visible = (step > 0);
            nextButton.Visible = (step < count - 1);
            finishButton.Visible = (step == count - 1);
        }

        /// Reload ComboBox 
        /// </summary>
        private async void reloadCombo()
        {
            #region ComboBox CardType && GroupComboBox

            RestfulHelper restfulHelper = new RestfulHelper(HttpClientData.baseUrl);
            string resultContent = await restfulHelper.request("/api/get-data");


            dataResult = JsonConvert.DeserializeObject<Model.ComboDataModel>(resultContent);

            groupComboBox.DisplayMember = "name";
            groupComboBox.ValueMember = "id";
            groupComboBox.DataSource = dataResult.successGroup;

            #endregion
        }


        /// <summary>
        /// Previous Button
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>

        private void previousButton_Click(object sender, EventArgs e)
        {
            int step = 0;
            step = mainTabControl.SelectedIndex;
            // Get step
            previouseStep(step);
        }

        /// <summary>
		/// Select previous step
		/// </summary>
		/// <param name="step"></param>
		private void previouseStep(int step)
        {
            if (--step > -1)
                mainTabControl.SelectedIndex = step;
        }

        /// <summary>
        /// Next Button
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void nextButton_Click(object sender, EventArgs e)
        {
            int step = 0;
            CommandResult opResult = null;

            // Get step
            step = mainTabControl.SelectedIndex;

            // Validate step
            opResult = validate(step);

            if (opResult.status == BaseDAL.Base.EnumCommandStatus.success)
            {
                switch (step)
                {
                    case 0:
                        {
                            // Fill Search Data
                            string data = searchTextBox.Text.Trim();
                            loadData(data);
                            enableTab(viewTabPage, true);
                        }
                        break;
                    case 1:
                        {
                            // view info usr
                          
                            enableTab(fingerprintTabPage, true);

                        }
                        break;

                   

                    default:
                        break;
                }

                nextStep(step);
            }

            else
                MessageBox.Show(opResult.model.ToString(), "اخطار", MessageBoxButtons.OK, MessageBoxIcon.Warning);
        }

        /// <summary>
        /// Load Data by code , nationalId
        /// </summary>
        /// <param name="data"></param>
        private async void loadData(string data)
        {
            try
            {
                DateTime nextYear = DateTime.Now.nextYear();

                RestfulHelper restfulHelper = new RestfulHelper(HttpClientData.baseUrl);

                //personResult = await restfulHelper.requestSearch(searchTextBox.Text.Trim(), "/api/get-fingerprint-user");

                if (personResult.success.Length > 0)
                {
                    PersonResponseData personResponseData = personResult.success[0] ?? null;

                    user_id = personResponseData.user_id;

                    //codeTextBox.Text =
                    //    personResponseData.user_id.ToString();

                    nameTextBox.Text =
                        personResponseData.people_name;

                    lastnameTextBox.Text =
                        personResponseData.people_lastname;

                    natioalcodeTextBox.Text =
                        personResponseData.people_nationalId;

                    //stateUserTextBox.Text =
                    //    personResponseData.user_state == 1 ? "کاربر فعال" : "کاربر غیرفعال";

                    codeTextBox.Text =
                        personResponseData.user_code;

                    stateFingerTextBox.Text = (personResponseData.fingerprint_id != null) ? "دارد" : "ندارد";

                    if (personResponseData.fingerprint_image != null)
                    {
                        fingerprintUserPictureBox.Image = byteArrayToImage(personResponseData.fingerprint_image);

                        //fingerprintUserPictureBox.Image = null;
                        //MemoryStream mem = new MemoryStream(personResponseData.fingerprint_image);
                        //fingerprintUserPictureBox.Image = Image.FromStream(mem);
                    }
                    else
                        fingerprintUserPictureBox.Image = SuprimaProgram.Properties.Resources.image_placeholder;

                    groupComboBox.SelectedValue =
                        personResponseData.group_id;

                }
                else
                {
                    MessageBox.Show("کد وارد شده نامعتبر می باشد", "اخطار", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
            catch (Exception ex)
            {
                LoggerExtensions.log(ex);
            }
        }

        /// <summary>
        /// Finish Button
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void finishButton_Click(object sender, EventArgs e)
        {
            try
            {
                if (null != client)
                {
                    try
                    {
                        client.Close();
                        client = null;
                       
                    }
                    catch (Exception ex)
                    {
                        
                    }
                }

                connectThread?.Abort();
                CloseSuccess();
            }
            catch (Exception)
            {

                connectThread = null;
                
            }
           
        }

        /// <summary>
        /// Enable Tab
        /// </summary>
        /// <param name="page"></param>
        /// <param name="enable"></param>
        public void enableTab(TabPage page, bool enable)
        {
            enableControls(page.Controls, enable);
        }

        /// <summary>
		/// Enable Controls
		/// </summary>
		/// <param name="ctls"></param>
		/// <param name="enable"></param>
		private static void enableControls(Control.ControlCollection ctls, bool enable)
        {
            foreach (Control ctl in ctls)
            {
                ctl.Enabled = enable;
                enableControls(ctl.Controls, enable);
            }
        }

        /// <summary>
		/// Select next step
		/// </summary>
		/// <param name="step"></param>
		private void nextStep(int step)
        {
            if (step == mainTabControl.TabPages.Count - 1)
            {
                CloseSuccess();
            }
            else if (++step < mainTabControl.TabPages.Count)
                mainTabControl.SelectedIndex = step;
        }

        /// <summary>
		/// Close Form
		/// </summary>
		private void CloseSuccess()
        {
            DialogResult = System.Windows.Forms.DialogResult.OK;
            Close();
        }

        /// <summary>
        /// Check search data
        /// </summary>
        /// <param name="step"></param>
        /// <returns></returns>
        private CommandResult validate(int step)
        {
            CommandResult result;

            string data = searchTextBox.Text.Trim();

            if (data.isNullOrEmptyOrWhiteSpaceOrLen(10))
                result = CommandResult.makeErrorResult("ERROR", "کد کاربری وارد شده نامعتبر است");
            else
                result = CommandResult.makeSuccessResult("OK");

            return result;
        }

        /// <summary>
        /// Enroll Button
        /// </summary>
        /// <param name="sender"></param>
        /// <param name="e"></param>
        private void enrollButton_Click(object sender, EventArgs e)
        {
            if (devicesComboBox.Text != null)
            {
                enroll();

                readImage();

               

            }
            else
            {
                MessageBox.Show("لطفا نام دستگاه را انتخاب نمایید", "خطا", MessageBoxButtons.OK);
            }
            
        }

      

        /// <summary>
        /// Enroll 
        /// </summary>

        private void enroll()
        {
            receiveMode = EnumReceiveMode.TEXT;

            string msg =
                $"{FP.FingerPrintController.C_ENROLL}" +
                    $"{FP.FingerPrintController.C_SEPARATOR}{devicesComboBox.Text}" +
                    $"{FP.FingerPrintController.C_SEPARATOR}{0}" +
                    $"{FP.FingerPrintController.C_SEPARATOR}{subId}";

            write(client,
                   msg);
        }
        /// <summary>
        /// Read Image
        /// </summary>
        private void readImage()
        {
            receiveMode = EnumReceiveMode.TEXT;

            string msg = $"{FP.FingerPrintController.C_READ_IMAGE}" +
                         $"{FP.FingerPrintController.C_SEPARATOR}{devicesComboBox.Text}";

            write(client,
                   msg);
        }

        private void readTemplate()
        {
            receiveMode = EnumReceiveMode.TEXT;

            string msg =
                $"{FP.FingerPrintController.C_READ_TEMPLATE}" +
                   $"{FP.FingerPrintController.C_SEPARATOR}{devicesComboBox.Text}" +
                   $"{FP.FingerPrintController.C_SEPARATOR}{finger_user_id}";


            write(client,
                   msg);
        }


        /// <summary>
        /// Write to TCPClient
        /// </summary>
        /// <param name="client"></param>
        /// <param name="msg"></param>
        private void write(TcpClient client, string msg)
        {
            byte[] data = System.Text.Encoding.UTF8.GetBytes(msg);

            client.GetStream()
                .Write(data,
                        0,
                        data.Length);
        }
        
     
        /// <summary>
        /// Validate data
        /// </summary>
        /// <returns></returns>
        private CommandResult validateData()
        {
            CommandResult result;

            List<string> err = new List<string>();
            string name = nameTextBox.Text.Trim();
            string lastName = lastnameTextBox.Text.Trim();
            string nationalCode = natioalcodeTextBox.Text.Trim();
            string code = codeTextBox.Text.Trim();
          

            #region Validate
            if (name.isNullOrEmptyOrWhiteSpaceOrLen(50))
                err.Add("نام وارد شده نامعتبر می باشد");
            if (lastName.isNullOrEmptyOrWhiteSpaceOrLen(50))
                err.Add("نام خانوادگی وارد شده نامعتبر می باشد");
            if (nationalCode.isNullOrEmptyOrWhiteSpaceOrLen(10))
                err.Add("کد ملی وارد شده نامعتبر می باشد");
            if (code.isNullOrEmptyOrWhiteSpaceOrLen(50))
                err.Add("کد پرسنلی / دانشجویی وارد شده نامعتبر می باشد");
           

            #endregion

            // Check for errors
            if (err.Count > 0)
                result = CommandResult.makeErrorResult("ERROR", String.Join("\r\n", err.ToArray()));
            else
                result = CommandResult.makeSuccessResult("OK");

            return result;
        }

        private void saveFingerprintButton_Click(object sender, EventArgs e)
        {
            saveDB();
        }

        /// <summary>
        /// Save DB
        /// </summary>
        private async void saveDB()
        {
            try
            {
                CommandResult opResult = null;

                opResult = validateData();

                if (opResult.status == BaseDAL.Base.EnumCommandStatus.success)
                {
                    prepareData();

                }
                else
                {
                    MessageBox.Show(opResult.model.ToString(), "اخطار", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
            catch (Exception ex)
            {
                LoggerExtensions.log(ex);
            }
        }

        private async void prepareData()
        {

            Image image_fingerprint = enrollPictureBox.Image;
            
            PersonModel personModel = new PersonModel();

            personModel.success = new PersonResponseData[1];

            personModel.success[0] = new PersonResponseData();

            personModel.success[0].user_id = user_id;

            personModel.success[0].fingerprint_user_id = finger_user_id;

            personModel.success[0].fingerprint_quality = finger_image_quality;

            personModel.success[0].fingerprint_template = tData;

            //personModel.success[0].people_nationalId =
            //            natioalcodeTextBox.Text.Trim();

            //personModel.success[0].user_code =
            //            codeTextBox.Text.Trim();

            if (image_fingerprint != null)
            {
                MemoryStream ms = new MemoryStream();
                image_fingerprint.Save(ms, ImageFormat.Jpeg);
                //byte[] photo = new byte[ms.Length];
                //ms.Position = 0;
                //ms.Read(photo, 0, photo.Length);

                image_fingerprint.Save(ms, image_fingerprint.RawFormat);

                byte[] img = ms.GetBuffer();
                personModel.success[0].fingerprint_image = img;
            }


            string url = "api/store-fingerprint-user";


            RestfulHelper restfulHelper = new RestfulHelper(HttpClientData.baseUrl);

            string resultContent = await restfulHelper.requestSave(personModel,
                                                                     restfulHelper.baseUrl + url);

            if (null != resultContent)
            {

                MessageBox.Show("result : " + resultContent);
                if ("OK" == resultContent)
                {
                    MessageBox.Show(" اطلاعات با موفقیت ثبت شد ");
                    //ClearPanels(dataGroupBox);
                    //s.Clear();
                    //dateTextBox.Text = ExtensionsDateTime.toPersianDate(DateTime.Now.AddYears(1));
                }
                else if ("Unauthorized" == resultContent)
                {
                    //MessageBox.Show("");
                }
                else
                {
                    //messageLabel.Text = "خطا در ذخیره داده";
                }
            }

        }


        #endregion

        private async void testButton_Click(object sender, EventArgs e)
        {
            Image image_fingerprint = enrollPictureBox.Image;


            PersonModel personModel = new PersonModel();

            personModel.success = new PersonResponseData[1];

            personModel.success[0] = new PersonResponseData();

            personModel.success[0].user_id = 2;

            //personModel.success[0].fingerprint_user_id = 501;

            //personModel.success[0].fingerprint_quality = 98;

            //personModel.success[0].fingerprint_template = "454654654654654656ds";

            //////byte[] byteArray = ImageManipulation.ImgToByte(image_fingerprint);

            if (image_fingerprint != null)
            {
                personModel.success[0].fingerprint_image = imageToByteArray(image_fingerprint);
                //MemoryStream ms = new MemoryStream();
                //image_fingerprint.Save(ms, ImageFormat.Jpeg);
                ////byte[] photo = new byte[ms.Length];
                ////ms.Position = 0;
                ////ms.Read(photo, 0, photo.Length);

                //image_fingerprint.Save(ms, image_fingerprint.RawFormat);

                //byte[] img = ms.GetBuffer();
                //byte[] data = img.ToArray();

                //personModel.success[0].fingerprint_image = img.ToArray();
            }
            

            string url = "api/update-image-fingerprint";


            RestfulHelper restfulHelper = new RestfulHelper(HttpClientData.baseUrl);

            //string resultContent = await restfulHelper.requestSaveImage(personModel,
                                                                     //restfulHelper.baseUrl + url);
        }

        public byte[] imageToByteArray(System.Drawing.Image imageIn)
        {
            MemoryStream ms = new MemoryStream();
            imageIn.Save(ms, System.Drawing.Imaging.ImageFormat.Gif);
            return ms.ToArray();
        }

        public Image byteArrayToImage(byte[] byteArrayIn)
        {
            MemoryStream ms = new MemoryStream(byteArrayIn);
            Image returnImage = Image.FromStream(ms);
            return returnImage;
        }
    }
}
