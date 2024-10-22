describe("Login Test", () => {
//   before(() => {
//   });

  beforeEach(() => {
    cy.visit("http://localhost:8000/login");
    cy.get("#name").type("hoge");
    cy.get("#password").type("hogehoge");
    cy.contains("button", "ログイン").click();
    cy.url().should("include", "/top");
    cy.get("#map").should("be.visible");
  });

  it("walking buttons functionality verification", () => {
    const generateRoute = (buttonText) => {
      cy.contains(".generate-route", buttonText).click();
      cy.contains("#messages", "kmの経路ができました。").should("be.visible");
    };

    // 経路生成から散歩完了まで
    cy.get("#distance").select("1");
    cy.get("#distance").should("have.value", "1");
    generateRoute("経路を生成");
    generateRoute("もう一度生成する");
    cy.get("#decide-route").click();
    cy.get("#start-btn").click();
    cy.get("#finish-btn").click();

    // 経路生成から散歩中止まで
    generateRoute("経路を生成");
    cy.get("#stop-btn").click();
    cy.contains("button", "経路を生成").should("be.visible");
  });

  it("verify calendar functionality works correctly", () => {
    cy.contains("footer ul li", "カレンダー").click();

    const today = new Date();
    const currentMonth = `${today.getFullYear()}年${today.getMonth() + 1}月`;
    const prevMonth = `${today.getFullYear()}年${today.getMonth()}月`;

    cy.contains("#calendar #title", currentMonth).should("be.visible");
    cy.get("#calendar #prev").click();
    cy.contains("#calendar #title", prevMonth).should("be.visible");
    cy.get("#calendar .tbody").children().should("have.length.gte", 4);
  });
});
