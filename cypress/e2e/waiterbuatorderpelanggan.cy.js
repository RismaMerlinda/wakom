describe('Waiter - Membuat Pesanan Baru', () => {
  const baseUrl = 'https://warkom.my.id';

  beforeEach(() => {
    cy.visit(`${baseUrl}/login`);
    cy.get('input[name="username"]').type('waiter');
    cy.get('input[name="password"]').type('123');
    cy.get('button[type="submit"]').click();
    cy.url().should('include', '/waiter');
  });

  it('Membuat pesanan baru dari halaman create order waiter', () => {
    cy.visit(`${baseUrl}/waiter/orders/create`);

    // Pilih pelanggan
    cy.get('select[name="pelanggan_id"]').select('Andi Wijaya');

    // Isi jumlah menu dan trigger event onchange agar updateCart jalan
    cy.get('input[data-menu-id="1"]').clear().type('2').trigger('change');
    cy.wait(500); // beri waktu update keranjang
    cy.get('input[data-menu-id="2"]').clear().type('1').trigger('change');
    cy.wait(500);

    // Pastikan item muncul di keranjang
    cy.get('#cart-items').should('not.contain', 'Belum ada item');

    // Tunggu tombol aktif lalu klik
    cy.get('#order-button').should('not.be.disabled').click();

    // Pastikan redirect berhasil
    cy.url({ timeout: 10000 }).should('include', '/waiter/orders');

  });
});