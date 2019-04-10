using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace datatransfer
{
    class Month
    {
        public int MonthID { get; set; }
        public String MonthDate { get; set; }
        public bool MonthCompleted { get; set; }
        public List<Day> Days { get; set; }

        public Month()
        {
            Days = new List<Day>();
        }
    }
}
