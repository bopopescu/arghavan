using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SuprimaProgram.Model
{
    public class PersonModel
    {
        public PersonResponseData[] success
        {
            get;
            set;
        }
    }

    public class PersonResponseData
    {
         
        public string people_name
        {
            get;
            set;
        }

        public string people_lastname
        {
            get;
            set;
        }
        public string people_nationalId
        {
            get;
            set;
        }
        public string user_code
        {
            get;
            set;
        }

        public int? user_id
        {
            get;
            set;
        }

       
        public int? fingerprint_user_id
        {
            get;
            set;
        }

        public int? fingerprint_id
        {
            get;
            set;
        }

        public string fingerprint_template
        {
            get;
            set;
        }

        public int? fingerprint_quality
        {
            get;
            set;
        }

        public byte[] fingerprint_image
        {
            get;
            set;
        }


        public int? group_id
        {
            get;
            set;
        }

    }
}
