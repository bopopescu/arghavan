using SuprimaApp.Helper;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace SuprimaApp.Forms
{
    public partial class LoginForm : Form
    {
        #region Methods


        public
        LoginForm()
        {
            InitializeComponent();

            init();
        }

        private void
        init()
        {
            bindEvents();

            prepare();

        }
        /// <summary>
        /// Bind events
        /// </summary>

        private void
        bindEvents()
        {
            loginButton.Click += (s, e) => login();
            exitButton.Click += (s, e) => exit();
            passwordTextBox.KeyDown += (s, e) => loginKeyDown(s, e);
        }

        /// <summary>
        /// Key down login
        /// </summary>
        /// <param name="s"></param>
        /// <param name="e"></param>

        private void
        loginKeyDown(object s, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Enter)
            {
                if (!passwordTextBox.Text.isNullOrEmptyOrWhiteSpaceOrLen(50))
                {
                    login();
                }
                else
                    MessageBox.Show("گذر واژه نامعتبر است", "خطا", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        /// <summary>
        /// Prepare
        /// </summary>

        private void
        prepare()
        {
            versionLabel.Text = Assembly.GetExecutingAssembly().GetName().Version.ToString();
        }
        /// <summary>
        /// Login 
        /// </summary>

        private async void 
        login()
        {
            try
            {
                string user = usernameTextBox.Text.Trim();
                string pass = passwordTextBox.Text.Trim();

                if (!user.isNullOrEmptyOrWhiteSpaceOrLen(50) &&
                    !pass.isNullOrEmptyOrWhiteSpaceOrLen(50) &&
                    user.Length > 0 && pass.Length > 0)
                {
                    RestfulHelper resfulhelper = new RestfulHelper(HttpClientData.baseUrl);
                    string url = "api/login";


                    HttpClientData.token = await resfulhelper.connect(user, pass, resfulhelper.baseUrl + url);


                    if (null != HttpClientData.token)
                    {
                        PrimaryForm form = new PrimaryForm();
                        this.Hide();
                        form.ShowDialog();

                    }
                    else
                    {
                        MessageBox.Show("اتصال بانک اطلاعاتی برقرار نمی باشد", "خطا", MessageBoxButtons.OK, MessageBoxIcon.Error);

                    }

                }
                else
                    MessageBox.Show("لطفا مشخصات را کامل نمایید", "خطا", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            catch (Exception ex)
            {
                MessageBox.Show("خطای ناشناخته ", "خطا", MessageBoxButtons.OK, MessageBoxIcon.Error);
                LoggerExtensions.log(ex);
                Environment.Exit(0);

            }
        }

        /// <summary>
        /// exit
        /// </summary>
        private void
        exit()
        {
            try
            {
                Close();
            }
            catch (Exception ex)
            {

                LoggerExtensions.log(ex);
            }
        }
        #endregion
    }
}
