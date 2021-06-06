function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

const text = {
  'show comments': {
    'en': 'Show Comments',
    'zh-Hant-TW': '顯示留言'
  },
  'close comments': {
    'en': 'Close Comments',
    'zh-Hant-TW': '關閉留言'
  }
};
const lang = getCookie('lang') || 'en';
