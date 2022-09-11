/**
 *  To format a number (amount of money)
 * @param nombre 
 * @returns 
 */

 export const format_number = (nombre) => {
  return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'XAF' }).format(parseInt(nombre,10) || 0);
}