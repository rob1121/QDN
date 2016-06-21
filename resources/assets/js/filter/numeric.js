
export function numeric (value) {
    var val = typeof value !== 'undefined' ?  value : 'show';
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}