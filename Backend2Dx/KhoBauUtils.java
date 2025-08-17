package game.modules.slot.utils;

import game.modules.slot.entities.slot.khobau.Awards;
import game.modules.slot.entities.slot.khobau.CellKhoBau;
import game.modules.slot.entities.slot.khobau.KhoBauAward;
import game.modules.slot.entities.slot.khobau.KhoBauItem;
import game.modules.slot.entities.slot.khobau.KhoBauItems;
import game.modules.slot.entities.slot.khobau.KhoBauLines;
import game.modules.slot.entities.slot.khobau.Line;
import java.util.Iterator;
import java.util.List;
import java.util.Random;

public class KhoBauUtils {
     public static KhoBauItem[][] generateMatrix() {
          KhoBauItems items = new KhoBauItems();
          KhoBauItem[][] matrix = new KhoBauItem[3][5];

          for(int i = 0; i < 3; ++i) {
               for(int j = 0; j < 5; ++j) {
                    matrix[i][j] = items.random();
               }
          }

          return matrix;
     }

     public static KhoBauItem[][] generateMatrixNoHu(String[] lineArr) {
          KhoBauItem[][] matrix = new KhoBauItem[3][5];
          Random rd = new Random();
          int n = rd.nextInt(lineArr.length);
          int indexLineNoHu = Integer.parseInt(lineArr[n]) - 1;
          KhoBauLines lines = new KhoBauLines();
          KhoBauItems items = new KhoBauItems();
          Line lineNoHu = lines.get(indexLineNoHu);

          for(int i = 0; i < 3; ++i) {
               for(int j = 0; j < 5; ++j) {
                    boolean genRandom = true;

                    for(int k = 0; k < lineNoHu.getCells().size(); ++k) {
                         if (i == lineNoHu.getCell(k).getRow() && j == lineNoHu.getCell(k).getCol()) {
                              genRandom = false;
                              matrix[i][j] = KhoBauItem.POUCH;
                         }
                    }

                    if (genRandom) {
                         matrix[i][j] = items.random();
                    }
               }
          }

          return matrix;
     }

     public static String matrixToString(KhoBauItem[][] matrix) {
          StringBuilder builder = new StringBuilder();

          for(int i = 0; i < 3; ++i) {
               for(int j = 0; j < 5; ++j) {
                    builder.append(",");
                    builder.append(matrix[i][j].getId());
               }
          }

          if (builder.length() > 0) {
               builder.deleteCharAt(0);
          }

          return builder.toString();
     }

     public static Line getLine(KhoBauLines lines, KhoBauItem[][] matrix, int lineIndex) {
          Line line = lines.get(lineIndex - 1);
          Iterator var4 = line.getCells().iterator();

          while(var4.hasNext()) {
               CellKhoBau cell = (CellKhoBau)var4.next();
               KhoBauItem itemInMatrix = matrix[cell.getRow()][cell.getCol()];
               cell.setItem(itemInMatrix);
          }

          return line;
     }

     public static void calculateLine(Line line, List awardList) {
          for(int i = 0; i < line.getCells().size(); ++i) {
               int countNumItems = 0;
               KhoBauItem itemSample = line.getItem(i);

               for(int j = 0; j < line.getCells().size(); ++j) {
                    if (line.getItem(j) == itemSample || line.getItem(j) == KhoBauItem.BAG) {
                         ++countNumItems;
                    }
               }

               if (countNumItems >= 3) {
                    KhoBauAward award = Awards.getAward(itemSample, countNumItems);
                    if (award != null && !checkAwardExist(awardList, award)) {
                         awardList.add(award);
                    }
               }
          }

     }

     private static boolean checkAwardExist(List awardList, KhoBauAward awardLine) {
          Iterator var2 = awardList.iterator();

          KhoBauAward award;
          do {
               if (!var2.hasNext()) {
                    return false;
               }

               award = (KhoBauAward)var2.next();
          } while(award != awardLine);

          return true;
     }
}
