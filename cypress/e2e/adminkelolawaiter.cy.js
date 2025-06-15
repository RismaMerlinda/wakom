describe('Admin - Kelola Waiter', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);

    // Login sebagai admin
    cy.get('input[name="username"]').type('admin'); // ubah jika perlu
    cy.get('input[name="password"]').type('123');   // ubah jika perlu
    cy.get('button[type="submit"]').click();

    // Verifikasi berhasil login
    cy.url().should('include', '/admin');
  });

  it('Menghapus waiter bernama Kanaya', () => {
  cy.visit(`${baseUrl}/admin/waiter`);

  // Pastikan nama Kanaya muncul
  cy.contains('h3', 'Kanaya').should('exist');

  // Intercept konfirmasi window
  cy.on('window:confirm', (text) => {
    expect(text).to.include('Yakin ingin menghapus waiter ini');
    return true; // klik "Oke"
  });

  // Temukan container card yang mengandung nama Kanaya
  cy.contains('h3', 'Kanaya')
    .parents('div.bg-white') // container div utama dengan styling
    .within(() => {
      // Klik tombol hapus
      cy.contains('button', 'Hapus').click({ force: true });
    });

  // Verifikasi Kanaya sudah terhapus
  cy.contains('h3', 'Kanaya').should('not.exist');
});

});
