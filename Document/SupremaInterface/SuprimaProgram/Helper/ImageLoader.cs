using System;
using System.Drawing;
using System.IO;

namespace SuprimaProgram.Helper
{
    /// <summary>
    /// Image loader
    /// </summary>
    public class ImageLoader
    {
        public byte[] img;

        private int index = 0;

        /// <summary>
        /// Ctr
        /// </summary>
        /// <param name="size"></param>
        public ImageLoader(int size)
        {
            img = new byte[size];
        }

        /// <summary>
        /// Add bytes
        /// </summary>
        /// <param name="data"></param>
        public void addBytes(byte[] data)
        {
            Array.Copy(data,
                        0,
                        img,
                        index,
                        data.Length);

            index += data.Length;
        }


        public Bitmap toBitmap()
        {
            MemoryStream ms = new MemoryStream(img);

            ms.Position = 0;

            Bitmap bitamp = new Bitmap(ms);


            return bitamp;
        }

        /// <summary>
        /// Convert Image to byteArray
        /// </summary>
        /// <param name="imageIn"></param>
        /// <returns></returns>
        public byte[] imageToByteArray(System.Drawing.Image imageIn)
        {
            MemoryStream ms = new MemoryStream();
            imageIn.Save(ms, System.Drawing.Imaging.ImageFormat.Gif);
            return ms.ToArray();
        }

        /// <summary>
        /// Convert ByteArray to image
        /// </summary>
        /// <param name="byteArrayIn"></param>
        /// <returns></returns>

        public Image byteArrayToImage(byte[] byteArrayIn)
        {
            MemoryStream ms = new MemoryStream(byteArrayIn);
            Image returnImage = Image.FromStream(ms);
            return returnImage;
        }

    }
}
