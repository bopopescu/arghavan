using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SuprimaProgram.Helper
{
    public class HttpClientData
    {
        public static string token = string.Empty;
        public static string baseUrl = ConfigurationManager.AppSettings["url"].ToString();

    }
}
