# Introduction

This is a comprehensive employee management & payroll application built with Laravel 9 and Bootstrap 5.

# To-Do

# App

- [ ] App Settings and Controls
  - [ ] Departments
  - [ ] Closure tracking
  - [ ] Integrations (i.e. Send CRUD events to external application via Observers)
- [ ] Navigation search bar (e.g. Employees, Timesheets, ...)
- [ ] Company wide closures (via Settings) (With time-ahead scheduled, e.g. Christmas and New Years can be registered far in advance)

## Employees

- [ ] Supervisor tracking (e.g. Joan reports to Barry)
- [ ] Employee comments
- [X] General profile editing
- [ ] Employee Communication (e.g. Timesheets, Free form emails, PTO Rejections)
- [X] Time-Off Tracking / Requests
- [ ] Disbursements

## Payroll / Timesheets

- [X] Editing timesheet options (e.g. Period/Pay type)
- [ ] Time card tracking
- [ ] Exporting (PDF/Email)

## Reports

- [ ] Report Center
- [ ] Statistics/Graphs on pages

## Other

- [X] Block a user from logging in if their associated employee is not active
- [X] Heavy query caching (i.e. employees, timesheets)
- [X] Fix factories for tables with unique constraints (Timesheets, Timesheet Days)
- [X] Implement lang file for long/duplicated messages
- [X] When employees are terminated, reject all open PTO requests

# Usage

N/A

# Requirements & Dependencies

- PHP 8+
- Laravel 9.X+
- MySQL
- Bootstrap 5.X+

# Previews

TBD
