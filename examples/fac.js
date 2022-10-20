const fac = (x) => x == 0 ? 1 : x * fac(x - 1)
const entry = () => fac(5)
console.log(entry())