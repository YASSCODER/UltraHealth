/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package blog;

import Entities.Menu;
import Entities.Plat;
import Service.ServiceMenu;
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
public class FXMLMenuController implements Initializable {
       private Label label;

    @FXML
    private TextField tftitre;
    @FXML
    private Button stat;
    @FXML
    private TextField tfcategory;
    @FXML
    private TextField tfplats_id;
    @FXML
    private TableColumn<Menu, Integer> idt;
    @FXML
    private TableColumn<Menu, String> ttitre;
    @FXML
    private TableColumn<Menu, Integer> tcategory;
    @FXML
    private TableColumn<Menu, Integer> tplats_id;
    @FXML
    private TableView<Menu> tablem;
    @FXML
    private TextField idsup;
    @FXML
    private TextField tfsearch;
    private int vartri = 0;

    @Override
    public void initialize(URL url, ResourceBundle rb) {

    }


    @FXML
    private void AjouterMenu(ActionEvent event) {
        ServiceMenu sc = new ServiceMenu();
        Menu m = new Menu();
        
        m.setTitre(tftitre.getText());
        m.setCategory(tfcategory.getText());
        m.setPlats_id(Integer.parseInt(tfplats_id.getText()));

        sc.AjouterMenu(m);
        this.AfficherMenu(event);
    }

    @FXML
    private void AfficherMenu(ActionEvent event) {
        ServiceMenu sc = new ServiceMenu();
        ObservableList<Menu> menus = sc.AfficherMenu();
        idt.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Menu, String>("titre"));
        tcategory.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("category"));
        tplats_id.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("plats_id"));
        tablem.setItems(menus);

    }

    @FXML
    private void selectionner(MouseEvent event) {

        Menu m = tablem.getSelectionModel().getSelectedItem();

        idsup.setText(String.valueOf(m.getId()));
        tftitre.setText(m.getTitre());
        tfcategory.setText(String.valueOf(m.getCategory()));
        tfplats_id.setText(String.valueOf(m.getPlats_id()));
        
    }

    @FXML
    private void SupprimerMenu(ActionEvent event) {
        ServiceMenu sc = new ServiceMenu();
        sc.supprimerMenu(Integer.parseInt(idsup.getText()));
        this.AfficherMenu(event);

    }
    
        

     @FXML
    private StackPane root;
    
    @FXML
    private void CreerQR(ActionEvent event) {
        Menu m = tablem.getSelectionModel().getSelectedItem();
        
        QRCodeWriter qrCodeWriter = new QRCodeWriter();
        String myWeb = m.toString();
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
        
        Menu m = tablem.getSelectionModel().getSelectedItem();
        
        
        String myWeb = m.toString();
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
        ServiceMenu sc = new ServiceMenu();
    Menu m = tablem.getSelectionModel().getSelectedItem();
    
    m.setTitre(tftitre.getText());
    m.setCategory(tfcategory.getText());
    m.setPlats_id(Integer.parseInt(tfplats_id.getText()));
    
    sc.ModifierMenu(m);
    this.AfficherMenu(event);
    }

    @FXML
    private void searchkey(KeyEvent event) {
        ServiceMenu sc = new ServiceMenu();
        ObservableList<Menu> menus = sc.search(tfsearch.getText());
        idt.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Menu, String>("titre"));
        tcategory.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("category"));
        tplats_id.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("plats_id"));
        tablem.setItems(menus);
    }

    @FXML
    private void tributton(MouseEvent event) {
        ServiceMenu sc = new ServiceMenu();
        ObservableList<Menu> menus;
        if (vartri == 1) {
            vartri = 0;
            menus = sc.triasc();
        idt.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Menu, String>("titre"));
        tcategory.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("category"));
        tplats_id.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("plats_id"));
        tablem.setItems(menus);

        } else {
            vartri = 1;
            menus = sc.triadsc();
         idt.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("id"));
        ttitre.setCellValueFactory(new PropertyValueFactory<Menu, String>("titre"));
        tcategory.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("category"));
        tplats_id.setCellValueFactory(new PropertyValueFactory<Menu, Integer>("plats_id"));
        tablem.setItems(menus);

        }

    }
    
}
