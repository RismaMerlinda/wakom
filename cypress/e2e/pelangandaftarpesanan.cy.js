describe('Pelanggan - Melihat Daftar Pesanan', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);

    // Login sebagai pelanggan
    cy.get('input[name="username"]').type('pelanggan'); // ganti jika perlu
    cy.get('input[name="password"]').type('123');    // ganti jika perlu
    cy.get('button[type="submit"]').click();

    // Pastikan redirect berhasil
    cy.url().should('include', '/pesan');
  });

  it('Menampilkan halaman daftar pesanan', () => {
    // Akses halaman daftar pesanan
    cy.visit(`${baseUrl}/pesanan`);

    // Cek heading halaman
    cy.contains('Daftar Pesanan').should('be.visible');

    // Verifikasi minimal satu pesanan ditampilkan (ganti teks sesuai konten real)
    cy.get('div')
      .contains(/Pesanan #[0-9]+/i) // contoh: "Pesanan #123"
      .should('exist');

    // Cek jika ada detail pesanan (misal status atau total harga)
    cy.contains('Total: Rp').should('exist');
  });
});
