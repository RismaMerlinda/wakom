describe('Admin - Melihat Daftar Pelanggan', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);

    // Login sebagai admin
    cy.get('input[name="username"]').type('admin'); // sesuaikan jika perlu
    cy.get('input[name="password"]').type('123');   // sesuaikan jika perlu
    cy.get('button[type="submit"]').click();

    // Pastikan berhasil masuk ke dashboard admin
    cy.url().should('include', '/admin');
  });

  it('Menampilkan halaman daftar pelanggan', () => {
    // Kunjungi halaman pelanggan
    cy.visit(`${baseUrl}/admin/pelanggan`);

    // Cek judul halaman
    cy.contains('Daftar Pelanggan').should('be.visible');

    // Atau lebih spesifik jika tahu nama pelanggannya
    cy.contains('Username: pelanggan').should('exist');
  });
});
