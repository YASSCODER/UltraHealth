package com.mycompany.myapp.gui;


import java.util.HashMap;
import java.util.Map;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.EncodeHintType;
import com.google.zxing.MultiFormatWriter;
import com.google.zxing.client.j2se.MatrixToImageWriter;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.decoder.ErrorCorrectionLevel;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.List;
import com.codename1.ui.SideMenuBar;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.GridLayout;
import com.codename1.ui.list.DefaultListCellRenderer;
import com.mycompany.myapp.entities.Ingrediant;
import com.mycompany.myapp.services.ServiceIngrediant;
import java.util.ArrayList;



public class MyForm extends Form {

    public MyForm() {
        super(new BorderLayout());
           Toolbar tb = new Toolbar();
           
        setToolbar(tb);
        
        getTitleArea().setUIID("Container");
        setTitle("My Form");
        getContentPane().setScrollVisible(false);
         // Create a side menu bar
        TextField searchField = new TextField("", "Search by titre");
        Button searchButton = new Button("Search");
        tb.addComponentToSideMenu(searchField);
        tb.addComponentToSideMenu(searchButton);
         tb.addCommandToRightBar("Add", null, new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                ServiceIngrediant service = ServiceIngrediant.getInstance();
                
                Form hi2 = new Form("Ajout", BoxLayout.y());
               hi2.getToolbar().addCommandToLeftBar("Back", null, e->{new MyForm().show();});
                TextField tftitre= new TextField();
                TextField tfcaloris=new TextField();
                TextField tfpoids=new TextField();
                Button btn=new Button("Add to Ingrediants");
                hi2.add(tftitre);
                hi2.add(tfcaloris);
                hi2.add(tfpoids);
                hi2.add(btn);
                hi2.show();
                btn.addActionListener(new  ActionListener() {
                    @Override
                    public void actionPerformed(ActionEvent evt) {
                        service.addIngrediant(tftitre,tfcaloris,tfpoids);
                              
                    }

                 
                });
          
            }
        });
        
        
        // Add items to the side menu
     
        
        // Create a list to display the ingredients
        List<Ingrediant> ingrediantList = new List<>();
        ingrediantList.setRenderer(new IngrediantListRenderer());
        add(BorderLayout.CENTER, ingrediantList);

        // Retrieve the list of ingredients from the server using the ServiceIngrediant class
        ServiceIngrediant service = ServiceIngrediant.getInstance();
        service.getAllIngrediant();
        
            for (Ingrediant ingrediant : service.ingrediants) {
                ingrediantList.addItem(ingrediant);
            }
searchButton.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent evt) {
        // Get the search query from the text field
        String query = searchField.getText();
        ServiceIngrediant service = ServiceIngrediant.getInstance();
        
        ArrayList<Ingrediant> results = service.searchIngrediant(query);

     
              
        // Clear the existing list model
        List<Ingrediant> ingrediantList = new List<>();
        ingrediantList.setRenderer(new IngrediantListRenderer());
        add(BorderLayout.CENTER, ingrediantList);

        // Add the results to the list model
        for (Ingrediant result : results) {
            ingrediantList.addItem(result);
        }
    }
        
    
});

            ingrediantList.addActionListener(new ActionListener() {
    @Override
    
public void actionPerformed(ActionEvent evt) {
    // Get the selected Ingrediant object from the list
    Ingrediant selectedIngrediant = ingrediantList.getSelectedItem();

    // Create a container to hold all the details of the selected Ingrediant object
    Container detailsContainer = new Container(new GridLayout(3, 1));
    detailsContainer.add(new SpanLabel("Caloris: " + selectedIngrediant.getCaloris()));
    detailsContainer.add(new SpanLabel("Poids: " + selectedIngrediant.getPoids()));

    // Create the delete and update buttons
    Button deleteButton = new Button("Delete");
    Button updateButton = new Button("Update");
    Button qrButton = new Button("Generate QR");
    qrButton.addActionListener(new ActionListener(){
            public void actionPerformed(ActionEvent evt) {
                
                     

    }});
    // Add the buttons to the container
    Container buttonContainer = new Container(new FlowLayout(CENTER));
    buttonContainer.addAll(deleteButton, updateButton, qrButton);
    detailsContainer.add(buttonContainer);

    // Create the details form and add the container to it
    Form detailsForm = new Form(selectedIngrediant.getTitre(), new BorderLayout());
    detailsForm.add(BorderLayout.CENTER, detailsContainer);

    // Set the delete button's action listener
    deleteButton.addActionListener(e -> {
    // Show a confirmation dialog before deleting the ingredient
    boolean confirm = Dialog.show("Confirmation", "Are you sure you want to delete this ingredient?", "Yes", "No");
    if (confirm) {
        // Get the selected Ingrediant object from the list
        
        int id = selectedIngrediant.getId();
        
        // Call the Supprimer method to delete the ingredient
        ServiceIngrediant service = ServiceIngrediant.getInstance();
        service.Supprimer(id);
         List<Ingrediant>ingrediantList = new List<>();
                for (Ingrediant ingrediant : service.ingrediants) {
                    ingrediantList.addItem(ingrediant);
                }
      
       
    }
});
    

    // Set the update button's action listener
    
    
updateButton.addActionListener(new ActionListener() {
    @Override
    public void actionPerformed(ActionEvent evt) {
        // Get the selected Ingrediant object from the list
        Ingrediant selectedIngrediant = ingrediantList.getSelectedItem();

        // Create a form to display the text fields for updating the ingredient
        Form updateForm = new Form("Update " + selectedIngrediant.getTitre(), new BorderLayout());

        // Create text fields for updating the ingredient's attributes
        TextField titreField = new TextField(selectedIngrediant.getTitre(), "Title");
        TextField poidsField = new TextField(String.valueOf(selectedIngrediant.getPoids()), "Weight");
        TextField calorisField = new TextField(String.valueOf(selectedIngrediant.getCaloris()), "Calories");
       

        // Add the text fields to the form
        updateForm.add(BorderLayout.CENTER, BoxLayout.encloseY(titreField, calorisField, poidsField));

        // Create a button to submit the changes to the server
        Button updateButton = new Button("Update");
        updateButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                // Update the selected ingredient with the values from the text fields
              String titre = titreField.getText();
    int calories = Integer.parseInt(calorisField.getText());
    int poids = Integer.parseInt(poidsField.getText());
    int id = selectedIngrediant.getId();


                // Send the updated ingredient to the server using the ServiceIngrediant class
                ServiceIngrediant service = ServiceIngrediant.getInstance();
                service.updateIngrediant(titre, calories, poids, id);

                // Refresh the list of ingredients
                List<Ingrediant>ingrediantList = new List<>();
                for (Ingrediant ingrediant : service.ingrediants) {
                    ingrediantList.addItem(ingrediant);
                }

                
            }
        });
        updateForm.add(BorderLayout.SOUTH, updateButton);
  updateForm.getToolbar().addCommandToLeftBar("Back", null, e->{new MyForm().show();});
        // Show the update form
        updateForm.show();
    }
});

  detailsForm.getToolbar().addCommandToLeftBar("Back", null, e->{new MyForm().show();});
    // Show the details form
    detailsForm.show();
}

});
            
        
    }
    

   private static class IngrediantListRenderer extends DefaultListCellRenderer<Ingrediant> {
    @Override
    public Component getListCellRendererComponent(List list, Ingrediant value, int index, boolean isSelected) {
        // Use the Ingrediant object's getTitle() method to display its title in the list
        Label titleLabel = new Label(value.getTitre());

        // Create a container to hold all the other fields
        Container container = new Container(new FlowLayout(LEFT, 2));
        
        // Add the other fields to the container
        Label calorisLabel = new Label("Caloris: " + value.getCaloris());
        Label poidsLabel = new Label("Poids: " + value.getPoids());
        container.addAll(calorisLabel, poidsLabel);

        // Create a container to hold the title and the other fields
        Container listItem = new Container(new BorderLayout());
        listItem.add(BorderLayout.CENTER, container);
        listItem.add(BorderLayout.NORTH, titleLabel);
        // Create and add the button to the right of the container
        
        return listItem;
    }

   }
   
   

}
