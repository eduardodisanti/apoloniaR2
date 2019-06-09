/* *******************************************************************
   ** PCL.H definicion del pcl                                      **
   *******************************************************************
*/

#define A4      "%c&l026A"
#define SOBRE	"%c&l081A"
#define HAGAKI  "%c&l071A"

#define ESC       27
#define MARGENSUPERIOR 120

void pclGotoxy(int x, int y);
float imprimo_linea(int *, int l, float factory);
void preparoPagina();
float pitch(int factor);
void fontNormal();
void fontCondensado();
void fontExpandido();
void fontBold(int estado);
void cierroPagina();
void reset();
int  saltoHoja(int);
void apaisar();
void logo();
void setDobleFaz(int);
