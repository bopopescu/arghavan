using System;
using System.Drawing;
using System.IO;

namespace Test
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
    }
}
