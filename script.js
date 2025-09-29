const toggleButton = document.createElement('button');
toggleButton.textContent = '🌙 Dark Mode';
toggleButton.className = 'btn btn-primary';
document.querySelector('header').appendChild(toggleButton);

toggleButton.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  toggleButton.textContent =
    document.body.classList.contains('dark-mode')
      ? '☀️ Light Mode'
      : '🌙 Dark Mode';
});

const buyButtons = document.querySelectorAll('.article-card .btn');

buyButtons.forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    const mangaTitle = btn.parentElement.querySelector('h3').textContent;
    alert(`Anda memilih membeli manga: ${mangaTitle}`);
  });
});

async function fetchTopAnime() {
  try {
    const res = await fetch('https://api.jikan.moe/v4/top/anime?limit=3');
    const data = await res.json();
    const hero = document.getElementById('hero');
    const list = document.createElement('ul');
    list.innerHTML = `<h3>Top 3 Anime (API Jikan)</h3>`;
    data.data.forEach(anime => {
      const li = document.createElement('li');
      li.textContent = anime.title;
      list.appendChild(li);
    });
    hero.appendChild(list);
  } catch (err) {
    console.error('Gagal mengambil data anime:', err);
  }
}

fetchTopAnime();