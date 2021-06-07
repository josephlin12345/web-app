function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

const allowed_lang = ['en', 'zh-TW'];
const text = {
  'show comments': {
    'en': 'Show Comments',
    'zh-TW': '顯示留言'
  },
  'close comments': {
    'en': 'Close Comments',
    'zh-TW': '關閉留言'
  }
};
let lang = getCookie('lang');
if(!allowed_lang.includes(lang)) lang = 'en';