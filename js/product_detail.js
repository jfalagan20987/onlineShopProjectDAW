const btnReviews = document.querySelector('.reviews-list button');
const moreReviews = document.querySelector('.more-reviews');

btnReviews.addEventListener('click', ()=>{
  moreReviews.classList.toggle('hidden');
  btnReviews.textContent = moreReviews.classList.contains('hidden') ? 'See more' : 'See less';
})
