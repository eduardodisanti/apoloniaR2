#include <stdio.h>
#include <time.h>
#include "pcl.h"

int pitchAnterior;
int pitchActual;
int flagvolver;
int doblefaz;
int lado;

int main()
{
   int paginas = 0;
   float y;				// Aca se almacenan la posicion del "cabezal"
   int i, lineasImpresas;
   int c;				// Caracter leido del standard input
   int *s;
   int doblefaz;
   float factory;
   int flag;

   flagvolver=0;
   doblefaz = 0;
   pitchAnterior=12;

   reset();  
   saltoHoja(0);
       
   preparoPagina();
   y = MARGENSUPERIOR;
   
   factory = pitch(12);
   s = (int *)malloc(4096);		// Asigno un cacho de memoria anormal para cada linea

   c=0;  
   i=0;
   lineasImpresas = 0;
   flag = 1;
   while(flag==1)	// Mientras la stdin tenga algo
     {
       c=getc(stdin);
       if(c==10 || c==EOF || c==12) // Fines
           {
		pclGotoxy(0,y);
		factory = imprimo_linea(s, i, factory);

               if(c==12) // Fin de la hoja
                 {
                    if(saltoHoja(lineasImpresas)==0)
                     {
                       c=0;
                     }
                    y=factory;
                    lineasImpresas=0;
                 }

		i=0;
                y=factory;
                s[0]='\0';
                ++lineasImpresas;
                if(flagvolver==1)
                  {
                    pitch(pitchAnterior);
                    flagvolver=0;
                  }

               // ** Rajarium **
               if(c==EOF)
                  {
                   flag=0;
                  }
           }

       if(c==21) // Indicacion de doble faz
          {
              setDobleFaz(1);
              lineasImpresas=0;
          }
           
      s[i++]=c;
      s[i]='\0';			// No es necesario reventar todo el sistema no ?
     }

  free(s);				// Prolijamente libero la memoria
  reset();
  return(0);
}

float imprimo_linea(int *s, int l, float fy)
{
  int i, c, flag=0, attn_enfasis = 0;
  float factory = fy;

   // flag=0 codigos con escape (2 bytes)

      for(i=0;i<=l;i++)
       {
        c = s[i];
        if(flag!=0 && c!=27) // Aca se procesan todos los codigos con escape
            {
              switch(c)
                  {
                      case 14:  // Agrandar
                                  pitch(10);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;
                      case 20:  // Agrandar por una sola linea 
                                  flagvolver=1;
                                  pitch(10);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;

                      case 69 :  // Bold on
                                  fontBold(1);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;

                      case 70 :  // Bold off
                                  fontBold(0);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;

                      case 71 :  // Doble trazo on
                                  fontBold(2);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;

                      case 72 :  // Doble trazo on
                                  fontBold(0);
                                  flag = 0;
                                  attn_enfasis = 0;
                      break;

                      case 87: // Llego un ESC-W
                                  flag = 1;
                                  attn_enfasis = 1;
                      break;

                      case 49 : // los attn son positivos
                                  flag = 0;
                                  if(attn_enfasis==1)
                                    {
                                     factory = pitch(10);
                                    }
                                  attn_enfasis=0;
                      break;

                      case 48 : // los attn son negativos
                                  flag = 0;
                                  if(attn_enfasis==1)
                                     factory = pitch(pitchAnterior);
                                  attn_enfasis = 0;
                      break;
                  }
            }
        else    // Codigo de solo un byte
        {
         switch (c)
           {
               case 15 :
                         factory = pitch(18);
                       break;
               case 14 : 
                         factory = pitch(10);
                         flagvolver=1;
                       break;
               case 18 : 
                         factory = pitch(12);
                       break;
               case 20 : factory = pitch(12);
                       break;

               case 21:  // Doble Faz
                         attn_enfasis = 0;
                         setDobleFaz(1);
                         flagvolver=0;
                      break;

               case 23 : apaisar(); 
                         //factory = pitch(18);
                       break;
               case 27 : flag = 1;
                       break;

               default:  putc(s[i],stdout);
                       break;
           }
        }
       } 

   for(i=0;i<=l;i++)
        s[i]='\0';
   return(factory); 
}

void reset()
{
   printf("%cE",ESC);
   printf("%c%%-12345X",ESC);
   doblefaz=0;
}

void preparoPagina()
{
   printf(HAGAKI,ESC);		// Imprimo en A4
   printf("%c&l1E",ESC);	// Cambio el Margen superior
   doblefaz=0;
   apaisar();
}

void apaisar()
{
   printf("%c&l1O",ESC);
}

void pclGotoxy(int x, int y)
{
    printf("%c&a%dC",ESC,x);		// Posicion horizontal
    //printf("%c&a%dR",ESC,y);		// Posicion vertical
    printf("%c&a+%dV",ESC,y);
}

float pitch(int factor)
{
    float vmi;

    pitchAnterior = pitchActual;
    pitchActual=factor;
    if(factor==0)
       factor==1;
    vmi = 48 / (factor * 0.5889);
    printf("%c(s%dH",ESC,factor);

    printf("%c&l%fC",ESC,vmi);

    return(factor);
}

void fontNormal()
{
    printf("%c(s0S",ESC);
}

void fontCondensado()
{
    printf("%c(s4S",ESC);
}

void fontExpandido()
{
    printf("%c(s24S",ESC);
}

void fontBold(int estado)
{
  switch (estado)
    {
        case 1 : printf("%c(s3B",ESC);
                break;
        case 2 : printf("%c(s4B",ESC);
                break;
        case 0 : printf("%c(s0B",ESC);
                break;
    }
}

int saltoHoja(int lineasImpresas)
{
  int salte=0;

  if(lineasImpresas > 0)
   {
      salte=1;
      //logo();
  }
  return(salte);
}

void logo()
{
    struct tm *tiempo;

    tiempo = getdate("%D %H:%M");

    printf("%c*p0x10Y",ESC);
    printf("%c*t100R",ESC);
    printf("%c*r0F",ESC);
    printf("%c*r1A",ESC);
 
// ........--------........--------........--------........
// 00011111111111111111111111111000 
// 00100000000000000000000000000100
// 01000111111111111111111111100010
// 10001111110000000000001111110001
// 10011111110011000011001111111001
// 10011111110011000011001111111001
// 10011111110011000011001111111001
// 10011111110011000011001111111001
// 10011111110011000011001111111001
// 10011000000011000011000000011001
// 10011000000011000011000000011001
// 10011011110011000011000011011001
// 10011011011011000011000011011001
// 10011011001100000011000011011001
// 10011011000110000011000011011001
// 10011011000011000011000111011001
// 10011011000001100011001111011001
// 10011011000010110011011011011001
// 10011011000011011011110011011001
// 10011011000011001011100011011001
// 10011000000011000011000000011001
// 10011111110011000011001111111001
// 10011111110011000011001111111001
// 10011111110001100110001111111001
// 10011111110001100110001111111001
// 10011111110000011100001111111001
// 10011111110000000000001111110001
// 01000111111111111111111111000010
// 00100000000000000000000000000100

    // Aca viene la imago

printf("%c*b4W%c%c%c%c",ESC,0x1F,       0xFF,   0xFF,   0xF8);
printf("%c*b4W%c%c%c%c",ESC,0x20,	0x00,	0x00,	0x04);
printf("%c*b4W%c%c%c%c",ESC,0x47,	0xFF,	0xFF,	0xE2);
printf("%c*b4W%c%c%c%c",ESC,0x8F,	0xC0,	0x03,	0xF1);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x98,	0x0C,	0x30,	0x19);
printf("%c*b4W%c%c%c%c",ESC,0x98,	0x0C,	0x30,	0x19);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0xCC,	0x30,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x6C,	0x30,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x30,	0x30,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x18,	0x30,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x0C,	0x31,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x06,	0x33,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x0B,	0x36,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x0D,	0xBC,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x9B,	0x0C,	0xB8,	0xD9);
printf("%c*b4W%c%c%c%c",ESC,0x98,	0x0C,	0x30,	0x19);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xCC,	0x33,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xC6,	0x63,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xC6,	0x63,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xC1,	0xC3,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x9F,	0xC0,	0x03,	0xF9);
printf("%c*b4W%c%c%c%c",ESC,0x47,	0xFF,	0xFF,	0xC2);
printf("%c*b4W%c%c%c%c",ESC,0x20,	0x00,	0x00,	0x04);
printf("%c*b4W%c%c%c%c",ESC,0x1F,	0xFF,	0xFF,	0xF8);

/* if(doblefaz==1) 
  {
   if(lado > 2)
       lado = 1;
   printf("%c&a%dG",27,lado);
   ++lado;
  }
else
  { */
   printf("%c*rC",ESC);
/*  } */
/* pclGotoxy(100,0);
printf("Fecha:\n");

pclGotoxy(0,0);
printf("%c&a%dR",ESC,4);          // Posicion vertical
printf("aca estoy\n");

*/

pclGotoxy(0,MARGENSUPERIOR);
}

void setDobleFaz(int sino)
{
  
    if(sino==1)
        printf("%c&l1S",27); 
    else
        printf("%c&l0S",27);

    doblefaz = sino;
    lado     = 1;
}

