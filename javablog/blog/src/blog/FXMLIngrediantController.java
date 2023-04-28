/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package blog;

import com.google.zxing.BarcodeFormat;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.QRCodeWriter;
import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Application;
import javafx.embed.swing.SwingFXUtils;
import javafx.scene.Scene;
import javafx.scene.image.ImageView;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;

import Entities.Blog;
import Entities.Ingrediant;

import Service.ServiceIngrediant;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.Date;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.ObservableList;
import javafx.concurrent.Task;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.KeyEvent;
import javafx.scene.input.MouseEvent;
import javafx.stage.Stage;

import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.Image;
import com.itextpdf.text.Phrase;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.FileOutputStream;
import java.io.OutputStream;


import com.itextpdf.text.Paragraph;



import javax.imageio.ImageIO;




/**
 *
 * @author Mega-PC
 */
public class FXMLIngrediantController implements Initializable {

    private Label label;

    @FXML
    private TextField tftitre;
    @FXML
    private Button stat;
    @FXML
    private TextField tfcaloris;
    @FXML
    private TextField tfpoids;
    @FXML
    private TableColumn<Ingrediant, Integer> idt;
    @FXML
    private TableColumn<Ingrediant, String> ttitre;
    @FXML
    private TableColumn<Ingrediant, Integer> tcaloris;
    @FXML
    private TableColumn<Ingrediant, Integer> tpoids;
    @FXML
    private TableView<Ingrediant> tablec;
    @FXML
    private TextField idsup;
    @FXML
    private TextField tfsearch;
    private int vartri = 0;

    @Override
    public void initialize(URL url, ResourceBundle rb) {

    }


    @FXML
    private void AjouterIngrediant(ActionEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
        Ingrediant c = new Ingrediant();
        
        c.setTitre(tftitre.getText());
        c.setCaloris(Integer.parseInt(tfcaloris.getText()));
        c.setPoids(Integer.parseInt(tfpoids.getText()));

        sc.AjouterIngrediant(c);
        this.AfficherIngrediant(event);
    }

    @FXML
    private void AfficherIngrediant(ActionEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
        ObservableList<Ingrediant> ingredients = sc.AfficherIngrediant();

        idt.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Ingrediant, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("caloris"));
        tpoids.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("poids"));
        tablec.setItems(ingredients);

    }

    @FXML
    private void selectionner(MouseEvent event) {

        Ingrediant c = tablec.getSelectionModel().getSelectedItem();

        idsup.setText(String.valueOf(c.getId()));
        tftitre.setText(c.getTitre());
        tfcaloris.setText(String.valueOf(c.getCaloris()));
        tfpoids.setText(String.valueOf(c.getPoids()));
        
    }

    @FXML
    private void SupprimerIngrediant(ActionEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
        sc.supprimerIngrediant(Integer.parseInt(idsup.getText()));
        this.AfficherIngrediant(event);

    }
    
        

     @FXML
    private StackPane root;
    
    @FXML
    private void CreerQR(ActionEvent event) {
        Ingrediant c = tablec.getSelectionModel().getSelectedItem();
        
        QRCodeWriter qrCodeWriter = new QRCodeWriter();
        String myWeb = c.toString();
        int width = 300;
        int height = 300;
        String fileType = "png";
        
        BufferedImage bufferedImage = null;
        try {
            BitMatrix byteMatrix = qrCodeWriter.encode(myWeb, BarcodeFormat.QR_CODE, width, height);
            bufferedImage = new BufferedImage(width, height, BufferedImage.TYPE_INT_RGB);
            bufferedImage.createGraphics();
            
            Graphics2D graphics = (Graphics2D) bufferedImage.getGraphics();
            graphics.setColor(Color.WHITE);
            graphics.fillRect(0, 0, width, height);
            graphics.setColor(Color.BLACK);
            
            for (int i = 0; i < height; i++) {
                for (int j = 0; j < width; j++) {
                    if (byteMatrix.get(i, j)) {
                        graphics.fillRect(i, j, 1, 1);
                    }
                }
            }
            
            System.out.println("Success...");
            
        } catch (WriterException ex) {
            
        }
        
        ImageView qrView = new ImageView();
        qrView.setImage(SwingFXUtils.toFXImage(bufferedImage, null));
        
        StackPane root = new StackPane();
        root.getChildren().add(qrView);
        
        Scene scene = new Scene(root, 350, 350);
        Stage newStage = new Stage();
        newStage.setTitle("Hello World!");
        newStage.setScene(scene);
        newStage.show();
    }
    @FXML
    private void CreerPDF(ActionEvent event) {
        Ingrediant c = tablec.getSelectionModel().getSelectedItem();
        
        
        String myWeb = c.toString();
         Document document = new Document();
        try {
            PdfWriter.getInstance(document, new FileOutputStream("ex.pdf"));
            document.open();
            document.add(new Paragraph(myWeb));
            document.close();
            System.out.println("PDF created successfully");
        } catch (Exception e) {
            e.printStackTrace();
        }
        

    }
    
        
        
       // create a new PDF document


    

    @FXML
    private void ModifierIngrediant(ActionEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
    Ingrediant c = tablec.getSelectionModel().getSelectedItem();
    
    c.setTitre(tftitre.getText());
    c.setCaloris(Integer.parseInt(tfcaloris.getText()));
    c.setPoids(Integer.parseInt(tfpoids.getText()));
    
    sc.ModifierIngrediant(c);
    this.AfficherIngrediant(event);
    }

    @FXML
    private void searchkey(KeyEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
        ObservableList<Ingrediant> ingredients = sc.search(tfsearch.getText());
        idt.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Ingrediant, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("caloris"));
        tpoids.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("poids"));
        tablec.setItems(ingredients);
    }

    @FXML
    private void tributton(MouseEvent event) {
        ServiceIngrediant sc = new ServiceIngrediant();
        ObservableList<Ingrediant> ingredients;
        if (vartri == 1) {
            vartri = 0;
            ingredients = sc.triasc();
        idt.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Ingrediant, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("caloris"));
        tpoids.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("poids"));
        tablec.setItems(ingredients);

        } else {
            vartri = 1;
            ingredients = sc.triadsc();
         idt.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Ingrediant, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("caloris"));
        tpoids.setCellValueFactory(new PropertyValueFactory<Ingrediant, Integer>("poids"));
        tablec.setItems(ingredients);

        }

    }

}
