import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.LinkedList;



public class RunTimeChecker {

	private int numberOfFiles;
	String mainPath;
	File dir;
	ArrayList<File> allFiles;
	LinkedList<String> que;
	boolean first = true;
	String command;
	Process process;
	
	//gdzie path jest sciezka do głownego katalogu z programem
	public RunTimeChecker(String path){
		System.out.println(path);
		mainPath = path;
		numberOfFiles = 0;
		dir = new File(mainPath+"/uploads");
		allFiles = new ArrayList<File>();
		que = new LinkedList<String>();
		command = "java -cp " + mainPath + "/jar/DTP.jar jade.Boot -nomtp TestAgent:dtp.jade.test.TestAgent(" + mainPath +"/configuration.xml) InfoAgent:dtp.jade.info.InfoAgent DistributorAgent:dtp.jade.distributor.DistributorAgent CrisisManagerAgent:dtp.jade.crisismanager.CrisisManagerAgent";
		
	}
	
	public void work(){
		
	
		while(true){
			
			try{
				//jeśli ilosc folderow jest wieksza niz podczas poprzedniego sprawdzenia, dodaj nowe zadania do kolejki
				if(numberOfFiles < dir.listFiles().length){
					
					numberOfFiles = dir.listFiles().length;
					
					for(File f : dir.listFiles()){
						//jesli nowo dodanego folderu nie ma w spisie folderow, i jest on katalogiem, dodaj jego configuration.xml do kolejki
						if(!allFiles.contains(f) && f.isDirectory()){
							System.out.println("Dodanie " + f.getName());
							que.addLast(f.getAbsolutePath() + "/configuration.xml");  
							allFiles.add(f);
							System.out.println("Path "+f.getAbsolutePath() + "/configuration.xml");
						}
					}
				}
			
				
				//sprawdzenie czy program wytworzył pliki wynikowe, jeśli tak, uruchomienie kolejnego zadania
				if(first || (new File(mainPath + "finished.dat").exists() && new File(mainPath + "result.xls").exists())){
					System.out.println("Uruchomienie");
					first = false;
					String tempPath = que.poll();
					
					//kopiowanie pliku configuration.xml z katalogu zadania do katalogu głównego
					String orig = tempPath;
					String dest = mainPath+"/configuration.xml";
										
					InputStream in = new FileInputStream(orig);
					OutputStream out = new FileOutputStream(dest);
					
					byte[] buf = new byte[1024];
					int len;
					while((len = in.read(buf)) > 0) out.write(buf,0,len);
					System.out.println("Skopiowano");
					in.close();
					out.close();
					
					
					System.out.println(tempPath);
					System.out.println(mainPath);
					System.out.println(command);
					process = Runtime.getRuntime().exec(command);
					
				}
				
				Thread.sleep(10000);
				
			}catch(Exception e){
				e.printStackTrace();
			}
			
		}
	}	
}
