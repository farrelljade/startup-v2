import {test, expect} from "@playwright/test";

const prospect = async ({ page }) => {
    const body = (page.locator('body'));

    await page.getByRole('link', { name: 'Prospects Page' }).click();
    await page.getByRole('button', { name: 'Add Prospect' }).click();
    await page.locator('#input-41').click();
    await page.locator('#v-menu-43').getByText('Mikel Farrell').click();
    await page.locator('#input-44').click();
    await page.locator('#input-44').fill('Mikels Fuels');
    await page.getByRole('textbox', { name: 'Email Email' }).click();
    await page.getByRole('textbox', { name: 'Email Email' }).fill('mfuels@test.com');
    await page.locator('#input-48').click();
    await page.locator('#v-menu-50').getByText('Outbound Call').click();
    await page.getByRole('textbox', { name: 'Contact Name Contact Name' }).click();
    await page.getByRole('textbox', { name: 'Contact Name Contact Name' }).fill('Mike Jade');
    await page.getByRole('textbox', { name: 'Contact Role Contact Role' }).click();
    await page.getByText('Owner').click();
    await page.getByRole('textbox', { name: 'Phone Phone' }).click();
    await page.getByRole('textbox', { name: 'Phone Phone' }).fill('07989545121');
    await page.getByRole('textbox', { name: 'Line 1 Line' }).click();
    await page.getByRole('textbox', { name: 'Line 1 Line' }).fill('123 Test Street');
    await page.getByRole('textbox', { name: 'City City' }).click();
    await page.getByRole('textbox', { name: 'City City' }).fill('Bury');
    await page.getByRole('textbox', { name: 'County County' }).click();
    await page.getByRole('textbox', { name: 'County County' }).fill('Lancashire');
    await page.getByRole('textbox', { name: 'Post Code Post Code' }).click();
    await page.getByRole('textbox', { name: 'Post Code Post Code' }).fill('BL9 5II');
    await page.getByRole('button', { name: 'Create Prospect' }).click();
    await expect(body).toContainText(/Prospects Page/);
}

export { prospect };
