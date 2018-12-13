using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WindowsFormsApp1
{
    class ComboBoxItem
    {

        public DataTable Data
        {
            get;
            private set;
        }

        public ComboBoxItem(DataTable dt)
        {
            Data = dt;
        }

        public override string ToString()
        {
            return Data.TableName;
        }

    }
}
