describe('Login Admin dan Akses Dashboard Transaksi Warkom', () => {
  it('Berhasil login sebagai admin dan melihat dashboard transaksi', () => {
    cy.visit('https://warkom.my.id/login');

    // Isi form login
    cy.get('input[name="username"]').type('admin'); // Ganti dengan username admin sebenarnya
    cy.get('input[name="password"]').type('123'); // Ganti dengan password admin sebenarnya

    // Submit login
    cy.get('button[type="submit"]').click();

    // Pastikan URL mengarah ke dashboard admin
    cy.url().should('include', '/admin/transaksi');

    
  });
});
