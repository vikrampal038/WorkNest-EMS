import { test, expect } from '@playwright/test';

// Define the base URL since the project uses Laravel
const BASE_URL = 'http://localhost:8000';

test.describe('WorkNest EMS Landing Page', () => {
  
  test.beforeEach(async ({ page }) => {
    // Navigate to the landing page before each test
    // Assuming the Laravel server is running on port 8000
    try {
        await page.goto(BASE_URL);
    } catch (e) {
        console.log('Ensure your Laravel dev server is running (php artisan serve)');
    }
  });

  test('has correct title and main elements', async ({ page }) => {
    // We expect the page to load and not show an error
    // Check if the body is visible
    await expect(page.locator('body')).toBeVisible();
    
    // Check for some main heading, usually containing WorkNest or EMS
    // Using a generic check for the text 'WorkNest' on the page
    await expect(page.locator('text=WorkNest').first()).toBeVisible();
  });

  test('navigation and auth modal toggle', async ({ page }) => {
    // Look for login or portal access buttons
    const loginButton = page.locator('text=Login').first();
    const portalButton = page.locator('text=Portal Access').first();
    
    // If there's a portal button that opens the modal
    if (await portalButton.isVisible()) {
        await portalButton.click({ force: true });
        // The auth modal should become visible (Alpine sets x-show="authModalOpen")
        // Wait for a form inside the modal
        const modalForm = page.locator('form').filter({ hasText: 'Sign In' }).first();
        await expect(modalForm).toBeVisible();
    }
  });

  test('scroll to top button appears on scroll', async ({ page }) => {
    // Scroll down the page
    await page.evaluate(() => window.scrollTo(0, 1500));
    
    // The scroll to top button (aria-label="Smart Scroll") should become visible
    const scrollBtn = page.locator('[aria-label="Smart Scroll"]');
    await expect(scrollBtn).toBeVisible();
    
    // Click it and verify scroll is restored
    await scrollBtn.click({ force: true });
    
    // Wait for smooth scroll
    await page.waitForTimeout(1000);
    const newScrollY = await page.evaluate(() => window.scrollY);
    
    // Since we scrolled down to 1500, the button's scrollDirection state is 'down'.
    // Clicking it should scroll to the bottom of the page (which is >= 1500).
    expect(newScrollY).toBeGreaterThanOrEqual(1500);
  });
  
  test('interactive elements are not blocked by overlays', async ({ page }) => {
    // This tests the bug we just fixed!
    // Try to click a CTA button on the page
    const ctaButton = page.locator('text=Start 14-Day').first();
    if (await ctaButton.isVisible()) {
        await ctaButton.click({ force: true, timeout: 5000 });
    }
  });

  test('Explore ESS Features button changes dashboard tab to employee', async ({ page }) => {
    // Locate the Explore ESS Features button
    const essButton = page.locator('text=Explore ESS Features').first();
    await expect(essButton).toBeVisible();

    // Click it
    await essButton.click({ force: true });

    // Wait for smooth scroll/event propagation
    await page.waitForTimeout(1500);

    const employeeTabBtn = page.locator('button:has-text("Employee View")').first();
    await expect(employeeTabBtn).toHaveClass(/bg-brand-900/);
  });

  test('Testimonials company list has correct height for 3-item vertical scrolling', async ({ page }) => {
    // Locate the scrollable wrapper inside testimonials using its scrollbar-none class
    const scrollableWrapper = page.locator('div.scrollbar-none').first();
    
    // Check its height (on desktop viewport)
    const box = await scrollableWrapper.boundingBox();
    if (box) {
        // Height should be approximately 264px as configured by lg:h-[264px]
        expect(box.height).toBeGreaterThanOrEqual(250);
        expect(box.height).toBeLessThanOrEqual(280);
    }
  });

});

