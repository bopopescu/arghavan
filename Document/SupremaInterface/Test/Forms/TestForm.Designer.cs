namespace Test.Forms
{
    partial class TestForm
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose (bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose ();
            }
            base.Dispose (disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent ()
        {
            this.startButton = new System.Windows.Forms.Button();
            this.stopButton = new System.Windows.Forms.Button();
            this.enrollButton = new System.Windows.Forms.Button();
            this.identityButton = new System.Windows.Forms.Button();
            this.devicesComboBox = new System.Windows.Forms.ComboBox();
            this.clientConnectButton = new System.Windows.Forms.Button();
            this.logListBox = new System.Windows.Forms.ListBox();
            this.clientDisconnectButton = new System.Windows.Forms.Button();
            this.readTemplateButton = new System.Windows.Forms.Button();
            this.enrollTemplateButton = new System.Windows.Forms.Button();
            this.userIdUpDown = new System.Windows.Forms.NumericUpDown();
            this.label1 = new System.Windows.Forms.Label();
            this.identifyTemplateButton = new System.Windows.Forms.Button();
            this.picFinger = new System.Windows.Forms.PictureBox();
            this.imageButton = new System.Windows.Forms.Button();
            ((System.ComponentModel.ISupportInitialize)(this.userIdUpDown)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.picFinger)).BeginInit();
            this.SuspendLayout();
            // 
            // startButton
            // 
            this.startButton.Location = new System.Drawing.Point(20, 22);
            this.startButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.startButton.Name = "startButton";
            this.startButton.Size = new System.Drawing.Size(103, 35);
            this.startButton.TabIndex = 0;
            this.startButton.Text = "Start";
            this.startButton.UseVisualStyleBackColor = true;
            // 
            // stopButton
            // 
            this.stopButton.Location = new System.Drawing.Point(127, 22);
            this.stopButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.stopButton.Name = "stopButton";
            this.stopButton.Size = new System.Drawing.Size(103, 35);
            this.stopButton.TabIndex = 0;
            this.stopButton.Text = "Stop";
            this.stopButton.UseVisualStyleBackColor = true;
            // 
            // enrollButton
            // 
            this.enrollButton.Location = new System.Drawing.Point(20, 237);
            this.enrollButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.enrollButton.Name = "enrollButton";
            this.enrollButton.Size = new System.Drawing.Size(103, 35);
            this.enrollButton.TabIndex = 0;
            this.enrollButton.Text = "Enroll";
            this.enrollButton.UseVisualStyleBackColor = true;
            // 
            // identityButton
            // 
            this.identityButton.Location = new System.Drawing.Point(127, 237);
            this.identityButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.identityButton.Name = "identityButton";
            this.identityButton.Size = new System.Drawing.Size(103, 35);
            this.identityButton.TabIndex = 0;
            this.identityButton.Text = "Identify";
            this.identityButton.UseVisualStyleBackColor = true;
            // 
            // devicesComboBox
            // 
            this.devicesComboBox.FormattingEnabled = true;
            this.devicesComboBox.Location = new System.Drawing.Point(243, 197);
            this.devicesComboBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.devicesComboBox.Name = "devicesComboBox";
            this.devicesComboBox.Size = new System.Drawing.Size(212, 21);
            this.devicesComboBox.TabIndex = 1;
            // 
            // clientConnectButton
            // 
            this.clientConnectButton.Location = new System.Drawing.Point(20, 197);
            this.clientConnectButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.clientConnectButton.Name = "clientConnectButton";
            this.clientConnectButton.Size = new System.Drawing.Size(103, 35);
            this.clientConnectButton.TabIndex = 0;
            this.clientConnectButton.Text = "Client connect";
            this.clientConnectButton.UseVisualStyleBackColor = true;
            // 
            // logListBox
            // 
            this.logListBox.FormattingEnabled = true;
            this.logListBox.Location = new System.Drawing.Point(20, 104);
            this.logListBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.logListBox.Name = "logListBox";
            this.logListBox.Size = new System.Drawing.Size(435, 69);
            this.logListBox.TabIndex = 2;
            // 
            // clientDisconnectButton
            // 
            this.clientDisconnectButton.Location = new System.Drawing.Point(127, 197);
            this.clientDisconnectButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.clientDisconnectButton.Name = "clientDisconnectButton";
            this.clientDisconnectButton.Size = new System.Drawing.Size(103, 35);
            this.clientDisconnectButton.TabIndex = 0;
            this.clientDisconnectButton.Text = "Client DisConnect";
            this.clientDisconnectButton.UseVisualStyleBackColor = true;
            // 
            // readTemplateButton
            // 
            this.readTemplateButton.Location = new System.Drawing.Point(243, 237);
            this.readTemplateButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.readTemplateButton.Name = "readTemplateButton";
            this.readTemplateButton.Size = new System.Drawing.Size(103, 35);
            this.readTemplateButton.TabIndex = 0;
            this.readTemplateButton.Text = "Read Template";
            this.readTemplateButton.UseVisualStyleBackColor = true;
            // 
            // enrollTemplateButton
            // 
            this.enrollTemplateButton.Location = new System.Drawing.Point(243, 277);
            this.enrollTemplateButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.enrollTemplateButton.Name = "enrollTemplateButton";
            this.enrollTemplateButton.Size = new System.Drawing.Size(103, 35);
            this.enrollTemplateButton.TabIndex = 0;
            this.enrollTemplateButton.Text = "Enroll Template";
            this.enrollTemplateButton.UseVisualStyleBackColor = true;
            // 
            // userIdUpDown
            // 
            this.userIdUpDown.Location = new System.Drawing.Point(364, 31);
            this.userIdUpDown.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.userIdUpDown.Minimum = new decimal(new int[] {
            1,
            0,
            0,
            0});
            this.userIdUpDown.Name = "userIdUpDown";
            this.userIdUpDown.Size = new System.Drawing.Size(90, 20);
            this.userIdUpDown.TabIndex = 3;
            this.userIdUpDown.Value = new decimal(new int[] {
            1,
            0,
            0,
            0});
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(320, 32);
            this.label1.Margin = new System.Windows.Forms.Padding(2, 0, 2, 0);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(40, 13);
            this.label1.TabIndex = 4;
            this.label1.Text = "User id";
            // 
            // identifyTemplateButton
            // 
            this.identifyTemplateButton.Location = new System.Drawing.Point(350, 277);
            this.identifyTemplateButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.identifyTemplateButton.Name = "identifyTemplateButton";
            this.identifyTemplateButton.Size = new System.Drawing.Size(103, 35);
            this.identifyTemplateButton.TabIndex = 0;
            this.identifyTemplateButton.Text = "Identiy Template";
            this.identifyTemplateButton.UseVisualStyleBackColor = true;
            // 
            // picFinger
            // 
            this.picFinger.Location = new System.Drawing.Point(127, 277);
            this.picFinger.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.picFinger.Name = "picFinger";
            this.picFinger.Size = new System.Drawing.Size(103, 89);
            this.picFinger.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage;
            this.picFinger.TabIndex = 5;
            this.picFinger.TabStop = false;
            // 
            // imageButton
            // 
            this.imageButton.Location = new System.Drawing.Point(20, 277);
            this.imageButton.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.imageButton.Name = "imageButton";
            this.imageButton.Size = new System.Drawing.Size(103, 35);
            this.imageButton.TabIndex = 6;
            this.imageButton.Text = "Load Image";
            this.imageButton.UseVisualStyleBackColor = true;
            // 
            // TestForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(470, 370);
            this.Controls.Add(this.imageButton);
            this.Controls.Add(this.picFinger);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.userIdUpDown);
            this.Controls.Add(this.logListBox);
            this.Controls.Add(this.devicesComboBox);
            this.Controls.Add(this.stopButton);
            this.Controls.Add(this.identifyTemplateButton);
            this.Controls.Add(this.enrollTemplateButton);
            this.Controls.Add(this.readTemplateButton);
            this.Controls.Add(this.identityButton);
            this.Controls.Add(this.enrollButton);
            this.Controls.Add(this.clientDisconnectButton);
            this.Controls.Add(this.clientConnectButton);
            this.Controls.Add(this.startButton);
            this.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.Name = "TestForm";
            this.Text = "TestForm";
            ((System.ComponentModel.ISupportInitialize)(this.userIdUpDown)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.picFinger)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button startButton;
        private System.Windows.Forms.Button stopButton;
        private System.Windows.Forms.Button enrollButton;
        private System.Windows.Forms.Button identityButton;
        private System.Windows.Forms.ComboBox devicesComboBox;
        private System.Windows.Forms.Button clientConnectButton;
        private System.Windows.Forms.ListBox logListBox;
        private System.Windows.Forms.Button clientDisconnectButton;
        private System.Windows.Forms.Button readTemplateButton;
        private System.Windows.Forms.Button enrollTemplateButton;
        private System.Windows.Forms.NumericUpDown userIdUpDown;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button identifyTemplateButton;
        private System.Windows.Forms.PictureBox picFinger;
        private System.Windows.Forms.Button imageButton;
    }
}