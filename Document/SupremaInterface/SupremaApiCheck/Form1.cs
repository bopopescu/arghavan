using System;
using System.IO;
using System.Windows.Forms;
using Suprema.SFM_SDK_NET;
using System.Text;
using System.Threading;

namespace SupremaApiCheck
{
    public partial class Form1 : Form
    {
        private SupremaInterface.Suprema suprema = new SupremaInterface.Suprema ("DLL\\SFM_SDK.dll");

        private uint C_USER_ID = 1;

        private byte[] savedTemplate = null;
        private uint numOfLogCurrent = 0;
        Thread readLogThread;


        /// <summary>
        /// Ctr
        /// </summary>
        public
        Form1 ()
        {
            InitializeComponent ();

            init ();
        }


        /// <summary>
        /// Init
        /// </summary>
        private void
        init ()
        {
            connectButton.Click += (s, e) => connect ();
            disconnectButton.Click += (s, e) => disconnect ();
            enrollButton.Click += (s, e) => enroll ();
            identityButton.Click += (s, e) => identify ();
            readTemplateButton.Click += (s, e) => readTemplate ();
            identityTemplateButton.Click += (s, e) => identifyTemplate ();
            deleteButton.Click += (s, e) => deleteUser ();
            deleteAllButton.Click += (s, e) => deleteAll ();
            receivePacketButton.Click += receivePacketButton_Click;
            getNumOfLogButton.Click += getNumOfLogButton_Click;
            readLogButton.Click += readLogButton_Click;

        }

        private void readLogList()
        {
            try
            {
                readLogThread = null;
            }
            finally
            {
                readLogThread = null;
            }

            readLogThread = new Thread(() =>
            {
                // TODO: Check Counnect FP
                while ( true)
                {
                    
                    try
                    {
                        int startIndex = 0;
                        int count = 0;
                        uint numOfLog = 0;
                        uint numOfTotalLog = 0;
                        UFLogRecord[] logRecord = new UFLogRecord[50];
                        int readCount = 0;

                        suprema.getNumOfLog(ref numOfLog, ref numOfTotalLog);

                        if (numOfLog > numOfLogCurrent)
                        {
                            startIndex = Convert.ToInt32(numOfLogCurrent);
                            count = Convert.ToInt32(numOfLog - numOfLogCurrent);
                            numOfLogCurrent = numOfLog;

                            suprema.readLog(startIndex, count, logRecord, ref readCount);
                        }

                        for (int i = 0; i < readCount; i++)
                        {
                            string msg = $"{i}, -> Event: { GetEnumEventValues(logRecord[i].events) },\n\n" +
                                         $"Source:{ GetEnumSourceValues(logRecord[i].source) }, " +
                                         $"User:  { logRecord[i].userID }, " +
                                         $"Date:  { logRecord[i].date[0] + "-" + logRecord[i].date[1] + "-" + logRecord[i].date[2]  }," +
                                         $"time:  { logRecord[i].time[0] + ":" + logRecord[i].time[1] + ":" + logRecord[i].time[2] }";
                            log(msg);
                        }
                    }
                    catch (Exception ex)
                    {
                        log(ex.Message);
                    }
                }
            });

            readLogThread.Start();
        }
        private void getNumOfLogButton_Click(object sender, EventArgs e)
        {
            uint numOfLog = 0;
            uint numOfTotalLog = 0;
            suprema.getNumOfLog(ref numOfLog, ref numOfTotalLog);

            string msg = $"Num Of Log: {numOfLog}, Num Of Total Log: {numOfTotalLog}";

            log(msg);

        }

        private void readLogButton_Click(object sender, EventArgs e)
        {
            int startIndex = 0;
            int count = 0;
            uint numOfLog = 0;
            uint numOfTotalLog = 0;
            UFLogRecord[]  logRecord  = new UFLogRecord[50];
            int readCount = 0;

            suprema.getNumOfLog(ref numOfLog, ref numOfTotalLog);

            if (numOfLog > numOfLogCurrent)
            {
                startIndex = Convert.ToInt32(numOfLogCurrent);
                count = Convert.ToInt32(numOfLog - numOfLogCurrent);
                numOfLogCurrent = numOfLog;

                suprema.readLog(startIndex, count, logRecord, ref readCount);
            }


            for (int i = 0; i < readCount; i++)
            {
                string msg = $"{i}, -> Event: { GetEnumEventValues(logRecord[i].events) },\n\n" +
                             $"Source:{ GetEnumSourceValues(logRecord[i].source) }, " +
                             $"User:  { logRecord[i].userID }, " +
                             $"Date:  { logRecord[i].date[0] + "-" + logRecord[i].date[1] + "-" + logRecord[i].date[2]  }," +
                             $"time:  { logRecord[i].time[0] + ":" + logRecord[i].time[1] + ":" + logRecord[i].time[2] }";
                log(msg);
            }

        }

      
        private string GetEnumEventValues(int value)
        {
            Array enumValueArray = Enum.GetValues(typeof(UF_OUTPUT_EVENT));
            foreach (int enumValue in enumValueArray)
            {
                if (value == enumValue)
                    return Enum.GetName(typeof(UF_OUTPUT_EVENT), enumValue);
               // listBox1.Items.Insert(0, ("Name: " + Enum.GetName(typeof(UF_OUTPUT_EVENT), enumValue) + " , Value: " + enumValue));
            }

            return null;
           
        }

        private string GetEnumSourceValues(int value)
        {
            Array enumValueArray = Enum.GetValues(typeof(UF_LOG_SOURCE));
            foreach (int enumValue in enumValueArray)
            {
                if (value == enumValue)
                    return Enum.GetName(typeof(UF_LOG_SOURCE), enumValue);
                // listBox1.Items.Insert(0, ("Name: " + Enum.GetName(typeof(UF_OUTPUT_EVENT), enumValue) + " , Value: " + enumValue));
            }

            return null;

        }



    

        byte[] res = new byte[1024];
        private void receivePacketButton_Click(object sender, EventArgs e)
        {
            
            res =  suprema.receivePacket();
            log(ToString(res));
        }


        /// <summary>
        /// Delete user
        /// </summary>
        private void
        deleteAll()
        {
            suprema.deleteAll ();


            string msg = $"Delete all users";

            log (msg);
        }


        /// <summary>
        /// Delete user
        /// </summary>
        private void
        deleteUser ()
        {
            suprema.delete (C_USER_ID);


            string msg = $"Delete user";

            log (msg);
        }


        /// <summary>
        /// Identify Template
        /// </summary>
        private void
        identifyTemplate ()
        {
            uint userId = 0;
            byte subId = 0;

            suprema.identify ((uint)savedTemplate.Length,
                              savedTemplate,
                              ref userId,
                              ref subId);


            string msg = $"Template Identified, UserId: {userId}, SubId: {subId}";

            log (msg);
        }


        /// <summary>
        /// Read user template
        /// </summary>
        private void
        readTemplate ()
        {
            uint tmpSize = suprema.getTemplateSize ();

            byte[] data = new byte[tmpSize];

            uint numOfTemplates = 0;

            suprema.readTemplate (C_USER_ID,
                                  ref numOfTemplates,
                                  data);

            savedTemplate = data;
        }


        /// <summary>
        /// Identify
        /// </summary>
        private void
        identify ()
        {
            uint userId = 0;
            byte subId = 0;


            suprema.identify (ref userId,
                              ref subId);


            string msg = $"Identified as UserId:{userId}, SubId: {subId}";

            log (msg);
        }


        /// <summary>
        /// Enroll
        /// </summary>
        private void
        enroll ()
        {
            uint newUserId = 0;
            uint imageQuality = 0;


            suprema.enroll (C_USER_ID,
                            UF_ENROLL_OPTION.UF_ENROLL_NONE,
                            ref newUserId,
                            ref imageQuality);


            string msg = $"Enroll user 1 & Returned Id: {newUserId}, Image Quality: {imageQuality}";

            log (msg);
        }


        /// <summary>
        /// DisConnect 
        /// </summary>
        private void
        disconnect ()
        {
            suprema.close ();


            string msg = "DisConnect";

            log (msg);
        }


        /// <summary>
        /// Connect 
        /// </summary>
        private void
        connect ()
        {
            string data = File.ReadAllText (@"Config\config.json");

            UF_RET_CODE result;
            SupremaInterface.Suprema.DeviceConfigModel model =
                SupremaInterface.Suprema.DeviceConfigModel.loadConfig (data);

            result =  suprema.connect (model.ip,
                             model.port);

            if (result == UF_RET_CODE.UF_RET_SUCCESS)
            {
                readLogList();
            }
            

            string msg = "Connect";

            log (msg);
        }



        /// <summary>
        /// Log
        /// </summary>
        /// <param name="msg"></param>
        private void
        log (string msg)
        {
            this.Invoke(new Action(() =>
            {
                outputListBox.Items.Insert(0,
                                        msg);
            }));
        }

        private string ToString(byte[] bytes)
        {
            string response = string.Empty;

            foreach (byte b in bytes)
                response += (Char)b;

            return response;
        }
    }
}
