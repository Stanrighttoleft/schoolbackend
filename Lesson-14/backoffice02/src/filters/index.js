// import parseTime, formatTime and set to filter
export { parseTime, formatTime } from '@/utils'

//轉換ZIP郵遞區號為地區名稱
export function zipToStr(myzip,options1) {
  for (let i = 0; i < options1.length; i++) {
    for (let j = 0; j < options1[i].options2.length; j++) {
      if (options1[i].options2[j].value == myzip) {
        return (
          options1[i].label + " " + options1[i].options2[j].label
        );
      }
    }
  }
}
// check 檢查上傳的圖檔格式與大小
export function checkImage(file) {
  let retcode = { code: '200', data: '', message: '', status: 'OK' };
  const isImg =
    "image/jpeg,image/svg+xml,image/gif,image/png,image/webp".includes(file.type);
  const isLt2M = file.size / 1024 / 1024 < 2;
  if (!isImg) {
    retcode = { code: '200', data: '', message: '上傳文件不符合圖片格式！', status: 'FAIL' };
  }else if (!isLt2M) {
    retcode = { code: '200', data: '', message: '上傳圖片大小不可超過2M！', status: 'FAIL' };
  }
  return retcode;
}

/**
 * Show plural label if time is plural number
 * @param {number} time
 * @param {string} label
 * @return {string}
 */
function pluralize(time, label) {
  if (time === 1) {
    return time + label
  }
  return time + label + 's'
}

/**
 * @param {number} time
 */
export function timeAgo(time) {
  const between = Date.now() / 1000 - Number(time)
  if (between < 3600) {
    return pluralize(~~(between / 60), ' minute')
  } else if (between < 86400) {
    return pluralize(~~(between / 3600), ' hour')
  } else {
    return pluralize(~~(between / 86400), ' day')
  }
}

/**
 * Number formatting
 * like 10000 => 10k
 * @param {number} num
 * @param {number} digits
 */
export function numberFormatter(num, digits) {
  const si = [
    { value: 1E18, symbol: 'E' },
    { value: 1E15, symbol: 'P' },
    { value: 1E12, symbol: 'T' },
    { value: 1E9, symbol: 'G' },
    { value: 1E6, symbol: 'M' },
    { value: 1E3, symbol: 'k' }
  ]
  for (let i = 0; i < si.length; i++) {
    if (num >= si[i].value) {
      return (num / si[i].value).toFixed(digits).replace(/\.0+$|(\.[0-9]*[1-9])0+$/, '$1') + si[i].symbol
    }
  }
  return num.toString()
}

/**
 * 10000 => "10,000"
 * @param {number} num
 */
export function toThousandFilter(num) {
  return (+num || 0).toString().replace(/^-?\d+/g, m => m.replace(/(?=(?!\b)(\d{3})+$)/g, ','))
}

/**
 * Upper case first char
 * @param {String} string
 */
export function uppercaseFirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
}
