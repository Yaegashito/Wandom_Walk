import globals from "globals";
import pluginJs from "@eslint/js";

export default [
  { files: ["**/*.js"], languageOptions: { sourceType: "module" } },
  {
    languageOptions: {
      globals: {
        ...globals.browser,
        ...globals.jest,
        cy: "readonly",
        Cypress: "readonly",
        before: "readonly",
        after: "readonly",
        describe: "readonly",
        it: "readonly",
      },
    },
  },
  pluginJs.configs.recommended,
];
