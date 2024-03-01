describe('Calendrier des Événements', () => {
  it('affiche le calendrier avec les événements', () => {
    cy.visit('https://localhost:8000/evenementiel'); 
    cy.get('#calendar').should('be.visible'); 
  });
});

it('ouvre les détails d\'un événement au clic', () => {
  cy.visit('https://localhost:8000/evenementiel');
  cy.get('.fc-event').first().click(); 
  cy.get('#eventDetailsModal').should('be.visible'); 
});

it('réserve un événement via le modal des détails', () => {
  cy.visit('https://localhost:8000/evenementiel');
  cy.get('.fc-event').first().click();
  cy.get('#btnReserver').click(); 
  cy.url().should('include', '/formulaires/evenementiel/new'); 
});