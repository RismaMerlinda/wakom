describe('Waiter - Menandai Pesanan Selesai', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    // Login sebagai waiter
    cy.visit(`${baseUrl}/login`);
    cy.get('input[name="username"]').type('waiter'); // Ganti jika username berbeda
    cy.get('input[name="password"]').type('123');    // Ganti jika password berbeda
    cy.get('button[type="submit"]').click();
    cy.url().should('include', '/waiter');
  });

  it('Melihat daftar pesanan dan menandai satu pesanan sebagai selesai', () => {
    cy.visit(`${baseUrl}/waiter/orders`);

    
    // Cari tombol "Tandai Selesai" pertama dan klik
    cy.contains('button', 'Tandai Selesai')
      .should('exist')
      .first()
      .click();

    // Validasi jika status berubah atau muncul notifikasi
    cy.contains(/Berhasil ditandai selesai|Pesanan selesai|Selesai/i).should('exist');
  });
});
