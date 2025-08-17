package game.modules.slot.utils;

import game.modules.slot.entities.slot.Cell;
import game.modules.slot.entities.slot.Line;
import game.modules.slot.entities.slot.ndv.NDVAward;
import game.modules.slot.entities.slot.ndv.NDVAwards;
import game.modules.slot.entities.slot.ndv.NDVItem;
import game.modules.slot.entities.slot.ndv.NDVItems;
import game.modules.slot.entities.slot.ndv.NDVLines;
import java.util.Iterator;
import java.util.List;
import java.util.Random;

public class NuDiepVienUtils {
     public static NDVItem[][] generateMatrix() {
          NDVItems items = new NDVItems();
          NDVItem[][] matrix = new NDVItem[3][5];

          for(int i = 0; i < 3; ++i) {
               for(int j = 0; j < 5; ++j) {
                    matrix[i][j] = items.random();
               }
          }

          return matrix;
     }

     public static NDVItem[][] generateMatrixNoHu(String[] lineArr) {
          NDVItem[][] matrix = new NDVItem[3][5];
          Random rd = new Random();
          int n = rd.nextInt(lineArr.length);
          int indexLineNoHu = Integer.parseInt(lineArr[n]) - 1;
          NDVLines lines = new NDVLines();
          NDVItems items = new NDVItems();
          Line lineNoHu = lines.get(indexLineNoHu);

          for(int i = 0; i < 3; ++i) {
               for(int j = 0; j < 5; ++j) {
                    boolean genRandom = true;

                    for(int k = 0; k < lineNoHu.getCells().size(); ++k) {
                         if (i == lineNoHu.getCell(k).getRow() && j == lineNoHu.getCell(k).getCol()) {
                              genRandom = false;
                              matrix[i][j] = NDVItem.NU_DIEP_VIEN;
                         }
                    }

                    if (genRandom) {
                         matrix[i][j] = items.random();
                    }
               }
          }

          return matrix;
     }

     public static String matrixToString(NDVItem[][] matrix) {
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

     public static Line getLine(NDVLines lines, NDVItem[][] matrix, int lineIndex) {
          Line line = lines.get(lineIndex - 1);
          Iterator var4 = line.getCells().iterator();

          while(var4.hasNext()) {
               Cell cell = (Cell)var4.next();
               NDVItem itemInMatrix = matrix[cell.getRow()][cell.getCol()];
               cell.setItem(itemInMatrix);
          }

          return line;
     }

     public static void calculateLine(Line line, List awardList) {
          for(int i = 0; i < line.getCells().size(); ++i) {
               int countNumItems = 0;
               NDVItem itemSample = (NDVItem)line.getCell(i).getItem();

               for(int j = 0; j < line.getCells().size(); ++j) {
                    if (line.getCell(j).getItem() == itemSample || line.getCell(j).getItem() == NDVItem.THAY_THE) {
                         ++countNumItems;
                    }
               }

               if (countNumItems >= 3) {
                    NDVAward award = NDVAwards.getAward(itemSample, countNumItems);
                    if (award != null && !checkAwardExist(awardList, award)) {
                         awardList.add(award);
                    }
               }
          }

     }

     private static boolean checkAwardExist(List awardList, NDVAward awardLine) {
          Iterator var2 = awardList.iterator();

          NDVAward award;
          do {
               if (!var2.hasNext()) {
                    return false;
               }

               award = (NDVAward)var2.next();
          } while(award != awardLine);

          return true;
     }
}
