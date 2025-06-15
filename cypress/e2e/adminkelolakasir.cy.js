describe('Admin Kelola Kasir', () => {
  it('Login sebagai admin dan akses halaman kelola kasir', () => {
    cy.visit('https://warkom.my.id/login');

    // Isi form login
    cy.get('input[name="username"]').type('admin'); // Ganti dengan username admin valid
    cy.get('input[name="password"]').type('123'); // Ganti dengan password admin valid

    // Submit form
    cy.get('button[type="submit"]').click();

    // Tunggu redirect ke dashboard
    cy.url().should('include', '/admin/transaksi');

    // Klik menu sidebar "Kelola Kasir"
    cy.contains('Kelola Kasir').click();

    // Verifikasi URL
    cy.url().should('include', '/admin/kasir');

    // Verifikasi tampilannya
    cy.contains('Kelola Kasir').should('exist');
    cy.contains('Tambah Kasir').should('exist');

    // Verifikasi daftar kasir muncul
    cy.get('div').contains('Fitri Sari').should('exist');
    cy.get('div').contains('budi').should('exist');

    // Pastikan tombol hapus ada
    cy.get('form button')
      .contains('Hapus')
      .should('exist');
  });
});
