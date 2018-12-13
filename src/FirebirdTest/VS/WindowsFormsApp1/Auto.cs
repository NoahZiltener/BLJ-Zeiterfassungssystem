using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WindowsFormsApp1
{
    class Auto
    {

        /// <summary>
        /// Constructor of this class
        /// </summary>
        public Auto(string farbe)
        {
            Farbe = farbe;
        }

        public int AktuelleGeschwindigkeit
        {
            get;
            private set;
        }

        public string Farbe
        {
            get;
            set;
        }

        public void Beschleunigen(int kmh)
        {
            AktuelleGeschwindigkeit += kmh;
        }
        


    }
}
