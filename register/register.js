<script>
  const showBtn = document.querySelector('.show-btn');
  const passwordInput = document.querySelector('input[type="password"]');

  showBtn.addEventListener('click', () => {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    showBtn.textContent = type === 'password' ? 'Show' : 'Hide';
  });
</script>
