using Newtonsoft.Json;
using SuprimaApp.Model;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;

namespace SuprimaApp.Helper
{
    public class RestfulHelper
    {
        public const string C_HEADER_ACCEPT = "Accept";
        public const string C_HEADER_BEARER = "Bearer";
        public const string C_HEADER_VALUE_APP_JSON = "application/json";
        public string token = "";
        public string baseUrl { get; private set; }

        public HttpClient client = new HttpClient();


        public RestfulHelper(string baseUrl)
        {
            this.baseUrl = baseUrl;

            client = new HttpClient();

            client.BaseAddress = new Uri(baseUrl);
        }

        /// <summary>
        /// Connect to Server
        /// </summary>
        /// <param name="username"></param>
        /// <param name="password"></param>
        /// <param name="url"></param>
        /// <returns></returns>
        public async Task<string> 
        connect(string username,
                string password,
                string url)
        {
            var content = new FormUrlEncodedContent(new[]
            {
                new KeyValuePair<string, string>("code", username),
                new KeyValuePair<string, string>("password", password),
            });

            var result = await client.PostAsync(url, content);

            string resultContent = await result.Content.ReadAsStringAsync();

            LoginResponseModel loginResult = JsonConvert.DeserializeObject<Model.LoginResponseModel>(resultContent);

            this.token = loginResult.success.token;

            return token;
        }

        /// <summary>
        /// is Connect
        /// </summary>
        public bool 
        isConnected
        {
            get
            {
                /// todo: get

                return false;
            }
        }

        /// <summary>
        /// Disconnect
        /// </summary>
        public void 
        disconnect()
        {
            //client.
        }

        /// <summary>
        /// Request 
        /// </summary>
        /// <param name="url"></param>
        /// <returns></returns>
        public async Task<string> 
        request(string url)
        {
            client.DefaultRequestHeaders.Accept.Clear();
            client.DefaultRequestHeaders.Accept.Add(new MediaTypeWithQualityHeaderValue(C_HEADER_VALUE_APP_JSON));

            client.DefaultRequestHeaders.Add(C_HEADER_ACCEPT, C_HEADER_VALUE_APP_JSON);
            client.DefaultRequestHeaders.Authorization =
                            new AuthenticationHeaderValue(C_HEADER_BEARER, HttpClientData.token);


            var result = await client.PostAsync(url, null);
            string resultContent = await result.Content.ReadAsStringAsync();

            return resultContent;
        }

        

        
    }
}
