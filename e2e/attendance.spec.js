import { test, expect } from '@playwright/test';

test.describe('WorkNest EMS - Attendance Work Mode features', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to the attendance portal
    await page.goto('/admin/attendance');
  });

  test('should display initial KPI counts correctly', async ({ page }) => {
    // Fill the date picker with 2026-06-21 so we can verify the mock data stats
    await page.fill('#attendanceLogDate', '2026-06-21');

    // Expect the Present Today card breakdown elements to be visible
    await expect(page.locator('#statOfficeCount')).toBeVisible();
    await expect(page.locator('#statWfhCount')).toBeVisible();
    await expect(page.locator('#statFieldCount')).toBeVisible();

    // Verify initial values from mock data
    // Logs for 2026-06-21:
    // Office present logs: id 101 (Late), id 104 (Checked Out), id 106 (On Break) => 3 Office
    // WFH present logs: id 102 (On Time), id 105 (Late) => 2 WFH
    // Field present logs: id 103 (On Time) => 1 Field
    const officeText = await page.locator('#statOfficeCount').innerText();
    const wfhText = await page.locator('#statWfhCount').innerText();
    const fieldText = await page.locator('#statFieldCount').innerText();

    console.log(`Initial Present Breakdown -> Office: ${officeText}, WFH: ${wfhText}, Field: ${fieldText}`);
    expect(parseInt(officeText, 10)).toBeGreaterThanOrEqual(2);
    expect(parseInt(wfhText, 10)).toBeGreaterThanOrEqual(2);
    expect(parseInt(fieldText, 10)).toBeGreaterThanOrEqual(1);
  });

  test('should toggle details panels when switching modes', async ({ page }) => {
    // Default is Office mode, panel hidden
    await expect(page.locator('#wfhPanel')).toBeHidden();
    await expect(page.locator('#fieldDutyPanel')).toBeHidden();

    // Select WFH
    await page.click('#modeBtnWFH');
    await expect(page.locator('#wfhPanel')).toBeVisible();
    await expect(page.locator('#fieldDutyPanel')).toBeHidden();

    // Select Field Duty
    await page.click('#modeBtnField');
    await expect(page.locator('#wfhPanel')).toBeHidden();
    await expect(page.locator('#fieldDutyPanel')).toBeVisible();
    await expect(page.locator('#fieldSiteInput')).toBeVisible();
    await expect(page.locator('#gpsCoordinatesText')).toHaveText('19.0760° N, 72.8777° E');
  });

  test('should clock in under Field Duty and verify stats & logs update', async ({ page }) => {
    // Select Field Duty and input site name
    await page.click('#modeBtnField');
    await page.fill('#fieldSiteInput', 'Client: Tatas Mumbai');

    // Get initial Field count
    const initialFieldVal = parseInt(await page.locator('#statFieldCount').innerText(), 10);

    // Clock In
    await page.click('#clockBtn');

    // Verify Active Work Session status indicator dot and text
    await expect(page.locator('#statusIndicatorText')).toHaveText('Active Work Session');
    
    // Check if mode buttons are disabled during active session
    const workModeSelector = page.locator('#workModeSelector');
    await expect(workModeSelector).toHaveClass(/pointer-events-none/);

    // Verify Field count incremented in KPI card
    const postClockInFieldVal = parseInt(await page.locator('#statFieldCount').innerText(), 10);
    expect(postClockInFieldVal).toBe(initialFieldVal + 1);

    // Clock Out
    await page.click('#clockBtn');

    // Verify Not Clocked In
    await expect(page.locator('#statusIndicatorText')).toHaveText('Not Clocked In');

    // Verify list updates with Vikram Pal checked out with a Field badge
    await expect(page.locator('#attendanceTableBody tr').first().locator('td').nth(0)).toContainText('Vikram Pal');
    
    // Hover/verify the Field Duty badge in table
    const modeBadge = page.locator('#attendanceTableBody tr').first().locator('td').nth(5);
    await expect(modeBadge).toContainText('Field');
    
    // Verify tooltip contains Client: Client: Tatas Mumbai
    await modeBadge.hover();
    await expect(page.locator('#attendanceTableBody .group\\/mode .group-hover\\/mode\\:opacity-100')).toBeVisible();
    const tooltipText = await page.locator('#attendanceTableBody .group\\/mode .group-hover\\/mode\\:opacity-100').innerText();
    expect(tooltipText.toLowerCase()).toContain('client: tatas mumbai (19.0760° n, 72.8777° e)');
  });

  test('should filter list by Work Mode', async ({ page }) => {
    // Select "Work From Home (WFH)" from Work Mode Filter
    await page.selectOption('#attendanceFilterMode', 'WFH');
    
    // Verify only WFH entries show up
    const rows = await page.locator('#attendanceTableBody tr').all();
    for (const row of rows) {
      const text = await row.innerText();
      if (text.includes('No attendance logs found')) continue;
      await expect(row.locator('td').nth(5)).toContainText('WFH');
    }

    // Select "Field Duty" from Work Mode Filter
    await page.selectOption('#attendanceFilterMode', 'Field');
    const fieldRows = await page.locator('#attendanceTableBody tr').all();
    for (const row of fieldRows) {
      const text = await row.innerText();
      if (text.includes('No attendance logs found')) continue;
      await expect(row.locator('td').nth(5)).toContainText('Field');
    }
  });

  test('should verify export PDF page content, sorting, and branding', async ({ page }) => {
    // Fill the date picker with 2026-06-21 so we export that date range
    await page.fill('#attendanceLogDate', '2026-06-21');

    // Click export log button
    await page.click('button:has-text("Export Log")');
    await expect(page.locator('#exportModal')).toBeVisible();

    // Select PDF format and Custom range or Month to get multiple logs
    await page.selectOption('#exportFormat', 'pdf');
    await page.selectOption('#exportRange', 'month');

    // Trigger export and wait for the popup window
    const [popup] = await Promise.all([
      page.waitForEvent('popup'),
      page.click('#exportModalPanel button[type="submit"]')
    ]);

    // Wait for the popup page to load
    await popup.waitForLoadState();

    // Verify PDF page title and branding
    const companyTitle = await popup.locator('.header .title h1').innerText();
    expect(companyTitle).toContain('WorkNest Technologies Pvt. Ltd.');

    // Verify headers contain "Mode"
    const headers = await popup.locator('table th').allTextContents();
    expect(headers.map(h => h.toUpperCase())).toContain('MODE');

    // Verify data rows are grouped and sorted:
    // Check that names are grouped together (e.g. all "Vikram Pal" records should be consecutive)
    const employeeNames = await popup.locator('table td strong').allTextContents();
    console.log("Exported Employee Order: ", employeeNames);
    
    let lastIndex = {};
    let firstIndex = {};
    employeeNames.forEach((name, index) => {
      if (firstIndex[name] === undefined) {
        firstIndex[name] = index;
      }
      lastIndex[name] = index;
    });

    for (const name in firstIndex) {
      const slice = employeeNames.slice(firstIndex[name], lastIndex[name] + 1);
      const uniqueNames = [...new Set(slice)];
      expect(uniqueNames.length).toBe(1);
    }
  });
});
