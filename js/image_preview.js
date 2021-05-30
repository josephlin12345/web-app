const image = document.getElementById('image');

image.addEventListener('change', e => {
  const image_preview = document.getElementById('image_preview');
  image_preview.src = URL.createObjectURL(e.target.files[0]);
});