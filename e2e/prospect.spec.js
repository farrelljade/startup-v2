import { test } from '@playwright/test';
import {login} from "./fixtures/login.js";
import {prospect} from "./fixtures/prospect.js";

test('adding a prospect', async ({ page }) => {
    await login({ page });
    await prospect({ page });
});
