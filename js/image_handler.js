const image = document.getElementById('image');
const image_preview = document.getElementById('image_preview');
const allowed_image_format = ['image/png', 'image/jpeg', 'image/gif'];

image.addEventListener('change', e => {
  if(e.target.files[0].size > 16777215) {
    alert('檔案需小於16MB(File must less than 16MB) !');
    image.value = '';
    image_preview.src = '';
  }
  else if(!allowed_image_format.includes(e.target.files[0].type)) {
    alert('檔案格式須為jpeg、png、gif(File type must be jpeg, png, gif) !');
    image.value = '';
    image_preview.src = '';
  }
  else {
    image_preview.src = URL.createObjectURL(e.target.files[0]);
  }
});