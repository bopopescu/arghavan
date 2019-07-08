namespace SuprimaProgram.Forms
{
    partial class PrimaryForm
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.identifyButton = new System.Windows.Forms.Button();
            this.connectButton = new System.Windows.Forms.Button();
            this.enrollButton = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // identifyButton
            // 
            this.identifyButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.identifyButton.Location = new System.Drawing.Point(59, 24);
            this.identifyButton.Margin = new System.Windows.Forms.Padding(2);
            this.identifyButton.Name = "identifyButton";
            this.identifyButton.Size = new System.Drawing.Size(132, 27);
            this.identifyButton.TabIndex = 20;
            this.identifyButton.Text = "شناسایی اثر انگشت";
            this.identifyButton.UseVisualStyleBackColor = true;
            // 
            // connectButton
            // 
            this.connectButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.connectButton.Location = new System.Drawing.Point(353, 24);
            this.connectButton.Margin = new System.Windows.Forms.Padding(2);
            this.connectButton.Name = "connectButton";
            this.connectButton.Size = new System.Drawing.Size(132, 27);
            this.connectButton.TabIndex = 21;
            this.connectButton.Text = "ارتباط با دستگاه";
            this.connectButton.UseVisualStyleBackColor = true;
            // 
            // enrollButton
            // 
            this.enrollButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.enrollButton.Location = new System.Drawing.Point(208, 24);
            this.enrollButton.Margin = new System.Windows.Forms.Padding(2);
            this.enrollButton.Name = "enrollButton";
            this.enrollButton.Size = new System.Drawing.Size(132, 27);
            this.enrollButton.TabIndex = 31;
            this.enrollButton.Text = "ثبت اثرانگشت";
            this.enrollButton.UseVisualStyleBackColor = true;
            // 
            // PrimaryForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(548, 76);
            this.Controls.Add(this.identifyButton);
            this.Controls.Add(this.enrollButton);
            this.Controls.Add(this.connectButton);
            this.Font = new System.Drawing.Font("Tahoma", 8.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.Margin = new System.Windows.Forms.Padding(2);
            this.Name = "PrimaryForm";
            this.RightToLeft = System.Windows.Forms.RightToLeft.Yes;
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "1";
            this.ResumeLayout(false);

        }

        #endregion
        private System.Windows.Forms.Button identifyButton;
        private System.Windows.Forms.Button connectButton;
        private System.Windows.Forms.Button enrollButton;
    }
}