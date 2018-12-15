export const toSpinalCase = function(obj) {
    let newObj = {}
    for (let key in obj) {
        let newKey = key.replace(/([A-Z])/g, (g) => `_${g[0].toLowerCase()}`);
        newObj[newKey] = obj[key];
    }
    return newObj;
}

export const myAlert = function(message) {
    alert(message);
} 

export default {
    toSpinalCase,
    myAlert
};