using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;


using FP = FingerPrintController;

namespace SuprimaProgram.Forms
{
    public partial class PrimaryForm : Form
    {

        #region Method

        
        public PrimaryForm()
        {
            InitializeComponent();

            init();
        }
        /// <summary>
        /// Initilizer
        /// </summary>
        private void init()
        {
            bindEvent();
            prepare();
        }

        /// <summary>
        /// Bind Event
        /// </summary>
        private void bindEvent()
        {
            
            connectButton.Click     += connectButton_Click;
            enrollButton.Click      += enrollButton_Click;
            this.FormClosing        += primaryForm_FormClosing;
        }

        private void primaryForm_FormClosing(object sender, FormClosingEventArgs e)
        {
            FP.FingerPrintController.stop();
        }


        /// <summary>
        /// Prepare
        /// </summary>
        private void prepare()
        {
            FP.FingerPrintController.start();

        }


        private void connectButton_Click(object sender, EventArgs e)
        {
            try
            {
                Forms.DeviceForm deviceForm = new Forms.DeviceForm();
                deviceForm.ShowDialog();
            }
            catch (Exception ex)
            {

                throw;
            }
        }

        private void enrollButton_Click(object sender, EventArgs e)
        {
            try
            {
                Forms.UserForm userForm = new Forms.UserForm();
                userForm.ShowDialog();
            }
            catch (Exception ex)
            {

                
            }
        }


        #endregion

       
    }
}
