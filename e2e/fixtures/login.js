import {expect} from "@playwright/test";

const login = async ({ page }) => {
    const body = (page.locator('body'));

    await page.goto('./login');

    await page.getByRole('textbox', { name: 'Email' }).click();
    await page.getByRole('textbox', { name: 'Email' }).fill('admin@admin.com');
    await page.getByRole('textbox', { name: 'Email' }).press('Tab');
    await page.getByRole('textbox', { name: 'Password' }).fill('password');
    await page.getByRole('button', { name: 'Log in' }).click();
    await expect(body).toContainText(/Recent Orders/);
}

export { login };
