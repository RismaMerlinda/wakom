describe('Pelanggan - Pesan Menu', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);

    // Login sebagai pelanggan
    cy.get('input[name="username"]').type('pelanggan');
    cy.get('input[name="password"]').type('123');
    cy.get('button[type="submit"]').click();

    cy.url().should('include', '/pesan');
  });

  it('Menambahkan menu ke keranjang dan memproses pemesanan', () => {
    cy.visit(`${baseUrl}/pesan`);

    // Temukan input jumlah pertama dan isi nilai
    cy.get('input[type="number"][data-menu-id]').first().as('qtyInput');

    // Masukkan jumlah menu
    cy.get('@qtyInput').clear().type('2').blur(); // blur memicu updateCart

    // Tunggu render selesai
    cy.wait(500);

    // Verifikasi item muncul di keranjang
    cy.get('#cart-items').should('not.contain', 'Belum ada item');

    // Pastikan tombol aktif dan klik pesan
    cy.get('#order-button').should('not.be.disabled').click();

    // Cek pesan sukses (ganti sesuai teks yang muncul)
    cy.contains('Pesanan berhasil').should('exist');
  });
});
