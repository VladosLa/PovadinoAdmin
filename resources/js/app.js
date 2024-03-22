const form = document.querySelector('#newsForm');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const formData = new FormData(form);
  const requestData = Object.fromEntries(formData.entries());

  try {
    const response = await fetch('http://localhost:8080/news.html', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(requestData),
    });

    if (!response.ok) {
      throw new Error('Failed to add news');
    }

    // Если запрос выполнен успешно, обновите страницу или выполните другие действия
    location.reload(); // Перезагрузите страницу
  } catch (error) {
    console.error('Error adding news:', error);
  }
});
