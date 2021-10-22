## Data Link

### Description
Allows data from other REDCap projects to be displayed as read-only fields on a single project's data entry forms.

### Setup
After downloading and enabling this module on your REDCap instance, it can be enabled at the project-level. Click the "Configure" button to add "linked" projects. Once one or more linked projects have been defined, setup can be completed using the "Data Link Config" link in the project sidebar.

### Usage
On the "Data Link Config" page, the first column will display a list of fields in the active project. An additional column should appear for each "linked" project and display their respective fields as well. Fields from the linked projects can be dragged and dropped into the active project's field list.

These fields will appear with data populated in Data Entry Forms. The fields will be read-only, but clicking the blue "link" button will open the original Data Entry Form (from the linked project) so the data can be modified.

Linked data will only be displayed if the logged in user has Data Viewing Rights for the form/project the data is being source from.