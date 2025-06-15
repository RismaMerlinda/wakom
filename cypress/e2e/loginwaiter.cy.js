describe('Waiter Login - Warkom', () => {
  it('should login successfully as admin and redirect', () => {
    cy.visit('https://warkom.my.id/login');

    // Input username admin
    cy.get('input[name="username"]').type('waiter'); // ganti jika username admin berbeda

    // Input password admin
    cy.get('input[name="password"]').type('123'); // ganti jika password admin berbeda

    // Klik tombol "Sign In"
    cy.get('button[type="submit"]').click();

    
  });
});
