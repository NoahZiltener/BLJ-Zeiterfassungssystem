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
        public TimeSpan overtime { get; set; }
        public TimeSpan worktime { get; set; }
        public TimeSpan lunchtime { get; set; } 

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
        public bool IsValidDay()
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
        public TimeSpan GetWorkTime()
        {
            
            return TimeOfDay;
        }
        public TimeSpan Getlunchtime()
        {
            TimeSpan TimeOfDay = new TimeSpan();
            DateTime firsttime = new DateTime();
            firsttime = Stamps.First().DateAndTime;
            DateTime lasttime = new DateTime();
            lasttime = Stamps.Last().DateAndTime;
            TimeOfDay = lasttime - firsttime;
            
            TimeSpan lunchtime = new TimeSpan();
            DateTime[] times = new DateTime[Stamps.Count()];
            int arrayindex = 0;
            foreach(Stamp s in Stamps)
            {
                times[arrayindex] = s.DateAndTime;
                arrayindex++;
            }
            if(times.Length > 0)
            {
                for (int i = 1; i < times.Length - 1; i = i +2)
                {
                    int i2 = 2;
                    DateTime stampout = new DateTime();
                    DateTime stampin = new DateTime();
                    stampout = times[i];
                    stampin = times[i2];
                    TimeSpan time = firsttime - lasttime;
                    lunchtime = lunchtime + time;
                    i2 = i2 + 2;
                }
            }
            Console.Write(lunchtime.TotalHours);
            return lunchtime;
        }
        public TimeSpan GetOverTime()
        {
            TimeSpan OverTime = new TimeSpan();
            DateTime firsttime = new DateTime();
            firsttime = Stamps.First().DateAndTime;
            DateTime lasttime = new DateTime();
            lasttime = Stamps.Last().DateAndTime;
            worktime = lasttime - firsttime;
            Console.WriteLine(worktime.TotalHours);
            return OverTime;
        }


    }
}
