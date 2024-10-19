describe("Login Test", () => {
  it("logs in successfully with valid credentials", () => {
    // ログインページにアクセス
    cy.visit("http://localhost:8000/login");

    // メールアドレスを入力
    cy.get("#name").type("hoge");

    // パスワードを入力
    cy.get("#password").type("hogehoge");

    // ログインボタンをクリック
    cy.contains("button", "ログイン").click();

    // URLがダッシュボードにリダイレクトされているか確認
    cy.url().should("include", "/top");

    // ダッシュボードの要素が表示されていることを確認
    cy.contains("footer li", "散歩");
  });
});
