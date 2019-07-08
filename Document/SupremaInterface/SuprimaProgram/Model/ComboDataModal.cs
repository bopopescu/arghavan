using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SuprimaProgram.Model
{
    public class ComboDataModel
    {
        public ModelData[] successGroup
        {
            get;
            set;
        }
    }


    public class ModelData
    {
        public int id
        {
            get;
            set;
        }

        public string name
        {
            get;
            set;
        }
    }
}
