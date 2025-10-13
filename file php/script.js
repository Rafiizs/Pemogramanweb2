// Menunggu hingga DOM sepenuhnya dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Dark Mode Toggle
    const toggleButton = document.createElement('button');
    toggleButton.textContent = '🌙 Dark Mode';
    toggleButton.className = 'btn';
    toggleButton.style.marginLeft = '10px';
    
    // Cari navigasi dan tambahkan tombol dark mode
    const nav = document.querySelector('header nav ul');
    if (nav) {
        const li = document.createElement('li');
        li.appendChild(toggleButton);
        nav.appendChild(li);
    }

    toggleButton.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        toggleButton.textContent =
            document.body.classList.contains('dark-mode')
                ? '☀️ Light Mode'
                : '🌙 Dark Mode';
        
        // Simpan preferensi dark mode di localStorage
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    });

    // Load dark mode preference dari localStorage
    if(localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        toggleButton.textContent = '☀️ Light Mode';
    }

    // Handle buy buttons
    const buyButtons = document.querySelectorAll('.article-card .btn');
    
    buyButtons.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const mangaTitle = btn.parentElement.querySelector('h3').textContent;
            const mangaPrice = btn.parentElement.querySelector('p:nth-child(3)')?.textContent || 'Rp 0';
            
            // Tampilkan konfirmasi sebelum redirect
            if(confirm(`Anda akan membeli: ${mangaTitle}\nHarga: ${mangaPrice}\nLanjutkan?`)) {
                window.location.href = btn.href;
            }
        });
    });

    // Fitur pencarian sederhana
    const searchForm = document.createElement('form');
    searchForm.innerHTML = `
        <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
            <input type="text" name="search" placeholder="Cari manga atau genre..." 
                   style="padding: 10px; width: 250px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px;">
            <button type="submit" class="btn">Cari</button>
        </div>
    `;
    searchForm.style.marginTop = '20px';
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = this.search.value.trim();
        if(searchTerm) {
            window.location.href = `index.php?search=${encodeURIComponent(searchTerm)}`;
        }
    });
    
    // Tambahkan form pencarian ke hero section
    const heroSection = document.getElementById('hero');
    if (heroSection) {
        heroSection.appendChild(searchForm);
    }

    // Animasi smooth scroll untuk navigasi
    document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Tambahkan efek loading untuk tombol
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            this.style.opacity = '0.7';
            setTimeout(() => {
                this.style.opacity = '1';
            }, 300);
        });
    });
});