describe('Kasir - Proses Pembayaran Pesanan', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);
    cy.get('input[name="username"]').type('kasir'); // Ganti jika bukan "kasir"
    cy.get('input[name="password"]').type('123');   // Ganti jika password berbeda
    cy.get('button[type="submit"]').click();
    cy.url().should('include', '/kasir');
  });

  it('Klik tombol Proses Pembayaran pada pesanan pertama', () => {
    cy.visit(`${baseUrl}/kasir/orders`);

    // Pastikan ada teks "Pesanan Menunggu Pembayaran"
    cy.contains('Pesanan Menunggu Pembayaran').should('exist');

    // Klik tombol "Proses Pembayaran" pertama
    cy.contains('button', 'Proses Pembayaran').first().click();

    // Validasi jika berhasil misalnya muncul notifikasi atau redirect
    cy.contains(/Berhasil dibayar|Sudah dibayar|Pembayaran berhasil/i).should('exist');
  });
});
