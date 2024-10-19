describe("Login Test", () => {
  before(() => {
    cy.visit("http://localhost:8000/login");
    cy.get("#name").type("hoge");
    cy.get("#password").type("hogehoge");
    cy.contains("button", "ログイン").click();
    cy.url().should("include", "/top");
    cy.contains("footer li", "散歩");
  });

  beforeEach(() => {
    cy.on('window:confirm', () => {
      return true;
    });
  });

  it("walking buttons functionality verification", () => {
    const generateRoute = (buttonText) => {
      cy.contains(".generate-route", buttonText).click();
      cy.contains("#messages", "kmの経路ができました。");
    };
    cy.get("#distance").select("1");
    cy.get("#distance").should("have.value", "1");
    generateRoute("経路を生成");
    generateRoute("もう一度生成する");
    cy.get("#decide-route").click();
    cy.get("#start-btn").click();
    cy.get("#finish-btn").click();
  });
});
