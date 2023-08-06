export const isInteger = (input) => {

    let reg = /^[0-9]+$/

    if (reg.test(input)) {
        return true;
    }
    return false
}

export const removeDuplicateSpaceAndTrim = (string) => {
    let reg = /[\s]+/g
    string = string.trim();
    return string.replace(reg, ' ');
}

export const noSpecialChars = (string) => {
    let reg = /^[\w-\s]+$/g
    if (reg.test(string)) {
        return true;
    }
    return false
}

export const isValidName = (string) => {
    let reg = /^[a-zA-Z ]{1,30}$/;
    return reg.test(string);
}

export const handleUpperCaseFirstLetter = (string) => {
    string = string.toLowerCase();
    let result = string.split(' ').map((word) => {
        return word.replace(word.charAt(0), word.charAt(0).toUpperCase());
    })
    return result.join(' ');
}

export const toSlug = (string) => {
    string = string.toLowerCase();
    let reg = /[\s]+/g
    return string.replace(reg,  '-');
}