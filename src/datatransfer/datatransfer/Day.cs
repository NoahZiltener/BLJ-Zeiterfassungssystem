using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace datatransfer
{
    class Day
    {
        public List<Stamp> Stamps { get; private set; }
        public DateTime DateOfDay { get; set; }
        public bool IsValid {get; set; }
        public int UserID { get; set; }

        public Day(DateTime dateOfDay, int userid)
        {
            DateOfDay = dateOfDay.Date;
            UserID = userid;
            Stamps = new List<Stamp>();
        }

        /// <summary>
        /// Für einen Tag muss zwingend eine gerade Anzahl Stamps vorhanden sein.
        /// </summary>
        /// <returns>True, if it's a valid day.</returns>
        private bool IsValidDay()
        {
            DateTime dt = new DateTime();

            if (Stamps.Count > 0)
            {
                dt = Stamps[0].DateAndTime.Date;

                foreach (Stamp s in Stamps)
                {
                    if (s.DateAndTime.Date != dt )
                        throw new Exception("Invalid Day object: stamps of different dates found!");
                    else if (s.DateAndTime.Date != DateOfDay)
                        throw new Exception("Invalid Day object: stamps with date different to DateOfDay found!");

                }
            }

            int count = 0;
            foreach (Stamp s in Stamps)
            {
                if (!s.IsIgnored)
                    count++;
            }

            if (count % 2 != 0)
                return false;

            return true;
        }


    }
}
