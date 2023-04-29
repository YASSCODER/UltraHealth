/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package blog;

import Entities.Ingrediant;
import Entities.Plat;
import Service.ServiceIngrediant;
import Service.ServicePlat;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.qrcode.QRCodeWriter;
import com.itextpdf.text.Document;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.pdf.PdfWriter;
import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.FileOutputStream;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.collections.ObservableList;
import javafx.embed.swing.SwingFXUtils;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.input.KeyEvent;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;

/**
 *
 * @author Mega-PC
 */
public class FXMLPlatController implements Initializable {
     private Label label;

    @FXML
    private TextField tftitre;
    @FXML
    private Button stat;
    @FXML
    private TextField tfcaloris;
    @FXML
    private TextField tfingrediants_id;
    @FXML
    private TableColumn<Plat, Integer> idt;
    @FXML
    private TableColumn<Plat, String> ttitre;
    @FXML
    private TableColumn<Plat, Integer> tcaloris;
    @FXML
    private TableColumn<Plat, Integer> tingrediants_id;
    @FXML
    private TableView<Plat> tablep;
    @FXML
    private TextField idsup;
    @FXML
    private TextField tfsearch;
    private int vartri = 0;

    @Override
    public void initialize(URL url, ResourceBundle rb) {

    }


    @FXML
    private void AjouterPlat(ActionEvent event) {
        ServicePlat sc = new ServicePlat();
        Plat p = new Plat();
        
        p.setTitre(tftitre.getText());
        p.setCaloris(Integer.parseInt(tfcaloris.getText()));
        p.setIngrediants_id(Integer.parseInt(tfingrediants_id.getText()));

        sc.AjouterPlat(p);
        this.AfficherPlat(event);
    }

    @FXML
    private void AfficherPlat(ActionEvent event) {
        ServicePlat sc = new ServicePlat();
        ObservableList<Plat> plats = sc.AfficherPlat();
        idt.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Plat, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("caloris"));
        tingrediants_id.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("ingrediants_id"));
        tablep.setItems(plats);

    }

    @FXML
    private void selectionner(MouseEvent event) {

        Plat p = tablep.getSelectionModel().getSelectedItem();

        idsup.setText(String.valueOf(p.getId()));
        tftitre.setText(p.getTitre());
        tfcaloris.setText(String.valueOf(p.getCaloris()));
        tfingrediants_id.setText(String.valueOf(p.getIngrediants_id()));
        
    }

    @FXML
    private void SupprimerPlat(ActionEvent event) {
        ServicePlat sc = new ServicePlat();
        sc.supprimerPlat(Integer.parseInt(idsup.getText()));
        this.AfficherPlat(event);

    }
    
        

     @FXML
    private StackPane root;
    
    @FXML
    private void CreerQR(ActionEvent event) {
        Plat p = tablep.getSelectionModel().getSelectedItem();
        
        QRCodeWriter qrCodeWriter = new QRCodeWriter();
        String myWeb = p.toString();
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
    
    // create a new PDF document
    @FXML
    private void CreerPDF(ActionEvent event) {
        
        Plat p = tablep.getSelectionModel().getSelectedItem();
        
        
        String myWeb = p.toString();
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
    
        
        
       


    

    @FXML
    private void ModifierPlat(ActionEvent event) {
        ServicePlat sc = new ServicePlat();
    Plat p = tablep.getSelectionModel().getSelectedItem();
    
    p.setTitre(tftitre.getText());
    p.setCaloris(Integer.parseInt(tfcaloris.getText()));
    p.setIngrediants_id(Integer.parseInt(tfingrediants_id.getText()));
    
    sc.ModifierPlat(p);
    this.AfficherPlat(event);
    }

    @FXML
    private void searchkey(KeyEvent event) {
        ServicePlat sc = new ServicePlat();
        ObservableList<Plat> plats = sc.search(tfsearch.getText());
        idt.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Plat, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("caloris"));
        tingrediants_id.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("ingrediants_id"));
        tablep.setItems(plats);
    }

    @FXML
    private void tributton(MouseEvent event) {
        ServicePlat sc = new ServicePlat();
        ObservableList<Plat> plats;
        if (vartri == 1) {
            vartri = 0;
            plats = sc.triasc();
        idt.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Plat, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("caloris"));
        tingrediants_id.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("ingrediants_id"));
        tablep.setItems(plats);

        } else {
            vartri = 1;
            plats = sc.triadsc();
         idt.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Plat, String>("titre"));
        tcaloris.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("caloris"));
        tingrediants_id.setCellValueFactory(new PropertyValueFactory<Plat, Integer>("ingrediants_id"));
        tablep.setItems(plats);

        }

    }

    
}
